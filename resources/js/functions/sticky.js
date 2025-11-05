import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

export default function stickyLeft() {
    const sections = document.querySelectorAll(".sticky-left-section");
    const header = document.querySelector("#header");

    if (!sections.length) return;

    const getHeaderHeight = () =>
        header ? header.getBoundingClientRect().height : 0;

    // Only run sticky logic on screens >= 992px
    ScrollTrigger.matchMedia({
        "(min-width: 992px)": function () {
            const initSticky = () => {
                const headerHeight = getHeaderHeight();
                const offsetStart = headerHeight + 10;

                sections.forEach(section => {
                    const sticky = section.querySelector(".sticky-left");
                    if (!sticky) return;

                    // Kill old triggers for this section
                    ScrollTrigger.getAll().forEach(trigger => {
                        if (trigger.trigger === section) trigger.kill();
                    });

                    gsap.delayedCall(0.2, () => {
                        ScrollTrigger.create({
                            trigger: section,
                            start: `top-=${offsetStart} top`, // start just before header overlaps
                            endTrigger: section,
                            end: "bottom bottom", // unpin when section bottom reaches viewport bottom
                            pin: sticky,
                            pinSpacing: true,
                            anticipatePin: 1,
                            scrub: false,
                            invalidateOnRefresh: true,
                            markers: false, // set to true for debugging
                            onRefreshInit: () => gsap.set(sticky, { clearProps: "all" }),
                        });
                    });
                });
            };

            // Run after all content has loaded
            window.addEventListener("load", () => {
                initSticky();
                ScrollTrigger.refresh();
            });

            window.addEventListener("resize", () => {
                ScrollTrigger.refresh();
                initSticky();
            });
        },
    });
}

document.addEventListener("DOMContentLoaded", stickyLeft);
