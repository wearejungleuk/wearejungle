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
                // Pin the sticky element 20px below the fixed header.
                const offsetStart = headerHeight + 20;

                sections.forEach(section => {
                    const sticky = section.querySelector(".sticky-left");
                    if (!sticky) return;

                    // Kill old triggers for this sticky element
                    ScrollTrigger.getAll().forEach(trigger => {
                        if (trigger.trigger === sticky || trigger.trigger === section) trigger.kill();
                    });

                    gsap.delayedCall(0.2, () => {
                        ScrollTrigger.create({
                            // Pin fires when the sticky element's top reaches
                            // header+20 from viewport top - so it visually pins
                            // 20px below the header.
                            trigger: sticky,
                            start: `top top+=${offsetStart}`,
                            // Unpin when the section's bottom reaches that same
                            // point - i.e. the sticky visually exits the
                            // section, at which point it goes back into normal
                            // flow and scrolls off with the rest of the section.
                            endTrigger: section,
                            end: `bottom top+=${offsetStart}`,
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
