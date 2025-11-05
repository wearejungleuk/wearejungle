import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

export default function heroAnimation() {
    const hero = document.querySelector('.home-hero');
    if (!hero) return;

    const title = hero.querySelector('.home-hero__title');
    const svgPaths = hero.querySelectorAll('svg path');
    const text = hero.querySelector('.home-hero__text');
    const cta = hero.querySelector('.home-hero__cta');
    const imageLeft = hero.querySelector('.home-hero__image-left');
    const imageRight = hero.querySelector('.home-hero__image-right');

    // --- Timeline setup ---
    const tl = gsap.timeline({
        defaults: { ease: "power2.out", duration: 0.8 },
        paused: true,
    });

    // --- 1. Title fade in and move up ---
    if (title) {
        tl.from(title, {
            opacity: 0,
            y: 40,
            duration: 1,
        });
    }

    // --- 2. SVG paths draw ---
    if (svgPaths.length) {
        svgPaths.forEach(path => {
            const length = path.getTotalLength();
            gsap.set(path, { strokeDasharray: length, strokeDashoffset: length });
        });

        // Draw them quickly with overlap
        tl.to(svgPaths, {
            strokeDashoffset: 0,
            duration: 2,
            stagger: 0.05,
        }, "-=0.4");
    }

    // --- 3. Text + CTA fade up together ---
    if (text || cta) {
        tl.from([text, cta], {
            opacity: 0,
            y: 25,
            stagger: 0.15,
            duration: 0.7,
        }, "-=0.3");
    }

    // --- 4. Images slide in from sides ---
    if (imageLeft) {
        tl.from(imageLeft, {
            x: -80,
            opacity: 0,
            duration: 0.9,
        }, "-=0.4");
    }

    if (imageRight) {
        tl.from(imageRight, {
            x: 80,
            opacity: 0,
            duration: 0.9,
        }, "-=0.8");
    }

    // --- Trigger the animation when in view ---
    ScrollTrigger.create({
        trigger: hero,
        start: "top 80%",
        once: true,
        onEnter: () => tl.play(),
    });
}

document.addEventListener('DOMContentLoaded', heroAnimation);
