import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

export default function stickyLeft() {
    const sections = document.querySelectorAll(".sticky-left-section");
    const header = document.querySelector("#header");

    if (!sections.length) return;

    const getHeaderHeight = () => (header ? header.getBoundingClientRect().height : 0);

    const initSticky = () => {
        const headerHeight = getHeaderHeight();
        const offsetStart = headerHeight + 10;

        sections.forEach(section => {
            const sticky = section.querySelector(".sticky-left");
            if (!sticky) return;

            // kill old triggers
            ScrollTrigger.getAll().forEach(trigger => {
                if (trigger.trigger === section) trigger.kill();
            });

            gsap.delayedCall(0.2, () => {
                const stickyHeight = sticky.offsetHeight;
                const sectionHeight = section.scrollHeight;

                ScrollTrigger.create({
                    trigger: section,
                    start: `top-=${offsetStart} top`, // start just before header overlaps
                    endTrigger: section,
                    end: "bottom bottom",
                    pin: sticky,
                    pinSpacing: true,
                    anticipatePin: 1,
                    scrub: false,
                    invalidateOnRefresh: true,
                    markers: false, // enable for debug
                    onRefreshInit: () => gsap.set(sticky, { clearProps: "all" }),
                });
            });
        });
    };

    window.addEventListener("load", () => {
        initSticky();
        ScrollTrigger.refresh();
    });

    window.addEventListener("resize", () => {
        ScrollTrigger.refresh();
        initSticky();
    });
}

document.addEventListener("DOMContentLoaded", stickyLeft);
