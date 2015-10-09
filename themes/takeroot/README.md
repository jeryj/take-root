What is Osteo?
============================

Osteo (bone) is a lightweight, well-coded WordPress theme. You won't find tons of unnecessary plugins. This theme is based on the _underscores WordPress theme, but has departed from there a lot.

The main goal is to have a simple, functional, stripped-down responsive structure ready to be quickly built off of.


Sass/SCSS & Susy
==========================
I like using SASS, and you might as well. If you don't, delete the stylesheets directory. Everything is in the style.css file anyways. But, it might look crazy since it's output from SASS. I'd recommend learning SASS if you want to use Osteo.

The only Sass dependancy is Susy. You can switch it out for a different grid system, but I think Susy is pretty legit.

More things to know. Osteo uses:

- box-sizing: border-box; because it's awesome for responsive development.
- em measurements for widths, fonts, padding, and more. I went em crazy, and I love it. Change it to rems and push it if you think it's better.
- Use @mixin media($width) for media queries. I generally just have 3 breakpoints: desktop, tablet, and mobile. You can see what they're set at in _grid.scss
- There's an ie.scss file for outputting CSS for supporting IE8 and under. It basically takes out anything that's under 48em and doesn't push that to the ie.css file. If you don't need to support IE8, then you can remove that file and save yourself some processing time when you generate your files. You can also remove the enqueueing of it from the functions.php file.
- gravity_forms.scss makes gravity forms output in a nicer format. If you're not using the gravity forms plugin (I don't plan to use it much), remove the gravity forms scss file and remove its import on style.scss and ie.scss.



Javascript
===========================

- scripts.js - All general scripts. I use jQuery, so that's where I put general site scripts. There's a bit in there that hooks up headroom.js and a responsive click-action menu. There's code in there to respond to a few breakpoints so you can easily hook into it. It's based on em instead of px. Hack away at it.
- headroom.min.js - This is an unobtrusive sticky header. It's simple, goes away when you don't want it, and shows up when a user scrolls up (when they're likely to want to interact with it).
- photoswipe - Photoswipe is an awesome gallery plugin. I kinda thought lightboxes were dead, but this is so simple and functional on all devices, it's pretty hard to beat. I have it hooked up to automatically be used for WordPress galleries. Also, I rewrote all WordPress gallery HTML and CSS so you actually want to use it again. It's responsive and semantic. Rad.
- tappy.js - Removes the 300ms delay for click on touch devices.
- picturefill.min.js - Lets you start using the future of responsive images today with srcset. Gallery thumbs use picturefill.

If you don't want to use some of these scripts (lots of times I don't), remove the js file(s), corresponding code from scripts.js, and remove the enqueueing of the file from the functions.php file. If you want to disable photoswipe for galleries, then also remove the require get_template_directory() . '/inc/photoswipe.php'; line from functions.php. That's where all the gallery shortcode html replacement is.


Style Guide
======================

There's a style guide folder in there that grabs all your current CSS and uses it in a heavily stripped down version of http://bjankord.github.io/Style-Guide-Boilerplate. If you don't need to use this for showing live styles to your clients, remove it.


Etc
======================

There's lots of things I do that I normally repeat myself on each project. I'll keep pushing updates to this as I remember them. Such as:

- responsive images for posts using picturefill
- single column blog and pages. I'm killing the sidebar for most projects.
- disqus for commenting.












