<?php
/**
 * ELEMENT: Arrow - Animated
 * Displays the arrow with animation on hover.
 *
 * Elements are analogous to 'Atoms' in Brad Frost's Atomic Design Methodology.
 *
 * @link    https://atomicdesign.bradfrost.com/chapter-2/#atoms
 */
?>
<span class="inline-flex items-center justify-center w-3.5 h-3 ml-1 relative overflow-hidden">
	<span class="shaft bg-foreground absolute top-50% w-0 h-0.5 invisible translate-x-0.75 transition-all ease-out group-hover/item:w-3 group-hover/item:visible group-hover/item:translate-x-0"></span>
	<svg xmlns="http://www.w3.org/2000/svg"
	     class="transition-transform ease-out w-auto h-full group-hover/item:translate-x-0.75" width="11.3"
	     height="16" viewBox="0 0 11.3 16">
		<path fill="currentColor" d="M0,0 4.4,0 11.3,8.2 4.4,16 0,16 7,8.3z"/>
	</svg>
</span>
