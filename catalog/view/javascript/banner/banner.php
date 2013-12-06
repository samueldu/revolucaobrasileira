<?php 
header("Content-type: text/css");  
?>

/* CSS for jQuery Orbit Plugin 1.2.1
 * www.ZURB.com/playground
 * Copyright 2010, ZURB
 * Free to use under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php


/* CONTAINER
   ================================================== */

div.orbit-wrapper {
    width: 980px;
    height: 1px;
    position: relative; }

div.orbit {
    height: 1px;
    overflow: hidden;
    position: relative;
    width: 1px;
    display: inline-block;}

div.orbit img {
    position: absolute;
    top: 0;
    left: 0;
    display: none; }

div.orbit a img {
    border: none }

.orbit div {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%; }


/* TIMER
   ================================================== */


/* CAPTIONS
   ================================================== */

.orbit-caption {
    display: none;
    font-family: "HelveticaNeue", "Helvetica-Neue", Helvetica, Arial, sans-serif; }

.orbit-wrapper .orbit-caption {
    background: #000;
    background: rgba(0,0,0,.6);

    color: #fff;
	text-align: center;
	padding: 7px 0;
    font-size: 13px;
    position: absolute;
    right: 0;
    bottom: 0;
    width: 100%; }


/* DIRECTIONAL NAV
   ================================================== */

div.slider-nav {
    display: block }

div.slider-nav span {
    width: 78px;
    height: 100px;
    text-indent: -9999px;
    position: absolute;
    z-index: 1000;
    top: 50%;
    margin-top: -42px;
    cursor: pointer; }

span.right {
    background: url(<?=$_GET['HTTP_IMAGE']?>orbit/right-arrow.png);
    right: 0;
   
	/* Firefox */
	-moz-transition-property: opacity;
	-moz-transition-duration: 2s;
	-moz-transition-delay: 1s;
	/* WebKit */
	-webkit-transition-property: opacity;
	-webkit-transition-duration: 2s;
	-webkit-transition-delay: 1s;
	/* Opera */
	-o-transition-property: opacity;
	-o-transition-duration: 2s;
	-o-transition-delay: 1s;
	/* Standard */
	transition-property: opacity;
	transition-duration: 2s;
	transition-delay: 1s;

 }

span.left {
    background: url(<?=$_GET['HTTP_IMAGE']?>orbit/left-arrow.png);
    left: 0;
    
	/* Firefox */
	-moz-transition-property: opacity;
	-moz-transition-duration: 2s;
	-moz-transition-delay: 1s;
	/* WebKit */
	-webkit-transition-property: opacity;
	-webkit-transition-duration: 2s;
	-webkit-transition-delay: 1s;
	/* Opera */
	-o-transition-property: opacity;
	-o-transition-duration: 2s;
	-o-transition-delay: 1s;
	/* Standard */
	transition-property: opacity;
	transition-duration: 2s;
	transition-delay: 1s;

    }

/* BULLET NAV
   ================================================== */

.orbit-bullets {
    position: absolute;
    z-index: 1000;
    list-style: none;
	right: 315px;
    left: 2px;
    top: 10px;
    padding: 0; }

.orbit-bullets li {
    float: left;
    margin-left: 5px;
    cursor: pointer;
    color: #999;
    text-indent: -9999px;
    background: url(<?=$_GET['HTTP_IMAGE']?>orbit/bullets.png) no-repeat 4px 0;
    width: 13px;
    height: 12px;
    overflow: hidden; }

.orbit-bullets li.active {
    color: #222;
    background-position: -8px 0; }
    
.orbit-bullets li.has-thumb {
    background: none;
    width: 100px;
    height: 75px; }

.orbit-bullets li.active.has-thumb {
    background-position: 0 0;
    border-top: 2px solid #000; }

span.right:hover {
    opacity: 1;}
    	
span.left:hover {
    opacity: 1; }