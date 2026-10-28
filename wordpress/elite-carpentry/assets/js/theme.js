/**
 * Elite Carpentry – small progressive enhancements. Everything works without JS.
 */
( function () {
	'use strict';

	document.documentElement.classList.add( 'js' );

	// Header shadow once the page scrolls.
	var header = document.querySelector( '.ec-header' );
	if ( header ) {
		var onScroll = function () {
			header.classList.toggle( 'is-scrolled', window.scrollY > 10 );
		};
		window.addEventListener( 'scroll', onScroll, { passive: true } );
		onScroll();
	}

	// Reveal sections as they enter the viewport.
	var reveals = document.querySelectorAll( '.ec-reveal' );
	if ( 'IntersectionObserver' in window ) {
		var io = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'is-visible' );
					io.unobserve( entry.target );
				}
			} );
		}, { rootMargin: '0px 0px -10% 0px' } );
		reveals.forEach( function ( el ) { io.observe( el ); } );
	} else {
		reveals.forEach( function ( el ) { el.classList.add( 'is-visible' ); } );
	}

	// Before/after slider: a Group with class "ec-before-after" holding two Image blocks.
	document.querySelectorAll( '.ec-before-after' ).forEach( function ( wrap ) {
		var images = wrap.querySelectorAll( ':scope > .wp-block-image' );
		if ( images.length < 2 ) {
			return;
		}
		var range = document.createElement( 'input' );
		range.type = 'range';
		range.min = '0';
		range.max = '100';
		range.value = '50';
		range.className = 'ec-ba__range';
		range.setAttribute( 'aria-label', 'Drag to compare before and after' );

		var handle = document.createElement( 'span' );
		handle.className = 'ec-ba__handle';
		handle.setAttribute( 'aria-hidden', 'true' );

		[ [ 'before', 'Before' ], [ 'after', 'After' ] ].forEach( function ( l ) {
			var label = document.createElement( 'span' );
			label.className = 'ec-ba__label ec-ba__label--' + l[ 0 ];
			label.textContent = l[ 1 ];
			wrap.appendChild( label );
		} );

		range.addEventListener( 'input', function () {
			wrap.style.setProperty( '--ec-pos', range.value + '%' );
		} );
		wrap.appendChild( handle );
		wrap.appendChild( range );
		wrap.classList.add( 'is-ready' );
	} );

	// Soft fallback for remote photos that fail to load.
	document.querySelectorAll( 'img' ).forEach( function ( img ) {
		var mark = function () { img.classList.add( 'ec-img-missing' ); };
		if ( img.complete && img.naturalWidth === 0 && img.currentSrc ) {
			mark();
		} else {
			img.addEventListener( 'error', mark, { once: true } );
		}
	} );
} )();
