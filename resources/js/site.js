import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
import morph from "@alpinejs/morph";
import persist from "@alpinejs/persist";
import focus from "@alpinejs/focus";
import ui from "@alpinejs/ui";
import masonry from "alpinejs-masonry";
import "focus-visible";

import Swiper from "swiper/bundle";
import "swiper/css/bundle";

window.Swiper = Swiper;

import hammerjs from "hammerjs";
window.Hammer = hammerjs;

// ✅ Import GSAP + ScrollTrigger
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

// ✅ Make available globally if needed
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

import './functions/fadeInOnScroll';
import './functions/smoothScroll';
import './functions/svg-draw';
import './functions/hero-animation';

// Call Alpine.
window.Alpine = Alpine;

Alpine.plugin([collapse, focus, morph, persist, ui]);
Alpine.plugin(masonry);

Alpine.start(); // Start Alpine

// fadeInOnScroll();