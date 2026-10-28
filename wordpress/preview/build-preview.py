# Rebuilds preview/index.html from a running local WordPress (http://localhost:8899) that has the theme, plugin and demo content installed.
import re, json, urllib.request, html
BASE='http://localhost:8899'
def get(p): return urllib.request.urlopen(BASE+p).read().decode('utf-8')
slugs=json.loads(get('/wp-json/wp/v2/ec_project?per_page=20&_fields=slug'))
terms=json.loads(get('/wp-json/wp/v2/ec_project_type?_fields=slug'))
routes=['/','/kitchens/','/bathrooms/','/services/','/about/','/contact/','/projects/']+['/projects/%s/'%s['slug'] for s in slugs]+['/project-type/%s/'%t['slug'] for t in terms]
css_cache={}
def css(href):
    if href not in css_cache:
        try: c=get(href.replace(BASE,''))
        except Exception as e: c=''
        base=href.split('?')[0].rsplit('/',1)[0]
        c=re.sub(r'url\((["\']?)(?!data:|https?:|#)([^)"\']+)\1\)', lambda m:'url(%s/%s)'%(base,m.group(2)), c)
        css_cache[href]=c
    return css_cache[href]
shared_order=[]; pages={}
for r in routes:
    h=get(r)
    # stylesheets -> shared
    def link(m):
        tag=m.group(0); href=html.unescape(re.search(r'href=[\'"]([^\'"]+)',tag).group(1))
        if href.startswith(BASE):
            if href not in shared_order: shared_order.append(href)
            return ''
        return tag
    h=re.sub(r'<link[^>]+rel=[\'"]stylesheet[\'"][^>]*>',link,h)
    # local scripts: inline theme.js, drop the rest
    def script(m):
        tag=m.group(0); src=re.search(r'src=[\'"]([^\'"]+)',tag)
        if src and src.group(1).startswith(BASE):
            if 'elite-carpentry/assets/js/theme.js' in src.group(1):
                return '<script>'+get(src.group(1).replace(BASE,''))+'</script>'
            return ''
        return tag
    h=re.sub(r'<script[^>]*src=[^>]*>\s*</script>',script,h)
    h=re.sub(r'<script type="importmap".*?</script>','',h,flags=re.S)
    h=re.sub(r'<script[^>]*type="module"[^>]*>.*?</script>','',h,flags=re.S)
    h=re.sub(r'<link[^>]+rel=[\'"](modulepreload|https://api.w.org/|alternate|EditURI|shortlink|canonical)[\'"][^>]*>','',h)
    # links -> preview routes
    h=re.sub(r'href="'+re.escape(BASE)+r'(/[^"#?]*)?([^"]*)"', lambda m:'href="#%s%s"'%(m.group(1) or '/', m.group(2) if m.group(2).startswith('#') else ''), h)
    h=re.sub(r'href="(/[a-z][^"]*)"', r'href="#\1"', h)
    h=h.replace('</head>','<!--SHARED--></head>',1)
    pages[r]=h
shared='\n'.join(css(x) for x in shared_order)
nav_script=r'''<script>
document.addEventListener('click',function(e){var a=e.target.closest('a');if(!a)return;var h=a.getAttribute('href')||'';
if(h.charAt(0)==='#'&&h.charAt(1)==='/'){e.preventDefault();var p=h.slice(1),i=p.indexOf('#');parent.postMessage({go:i>-1?p.slice(0,i):p,anchor:i>-1?p.slice(i+1):''},'*');}
else if(h.charAt(0)==='#'&&h.length>1){e.preventDefault();var t=document.getElementById(h.slice(1));if(t)t.scrollIntoView({behavior:'smooth'});}
else if(/^https?:/.test(h)){a.target='_blank';a.rel='noopener';}});
document.addEventListener('click',function(e){var o=e.target.closest('.wp-block-navigation__responsive-container-open'),c=e.target.closest('.wp-block-navigation__responsive-container-close');if(!o&&!c)return;var m=(o||c).closest('.wp-block-navigation').querySelector('.wp-block-navigation__responsive-container');m.classList.toggle('is-menu-open',!!o);m.classList.toggle('has-modal-open',!!o);},true);
document.addEventListener('submit',function(e){e.preventDefault();var f=e.target,n=document.createElement('p');n.className='ec-notice ec-notice--success';n.textContent='Preview only: on the live site this request would be saved under Quote Requests and emailed to you.';f.parentNode.insertBefore(n,f);n.scrollIntoView({behavior:'smooth',block:'center'});});
</script>'''
data={'css':shared,'nav':nav_script,'pages':pages}
tpl=open(__file__.rsplit('/',1)[0]+'/shell.html').read()
open(__file__.rsplit('/',1)[0]+'/index.html','w').write(tpl.replace('/*DATA*/null', json.dumps(data).replace('</','<\\/')))
print(len(routes),'pages', len(shared)//1024,'KB css')
