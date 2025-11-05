import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

export default function initBracketSVGs() {
    document.querySelectorAll('.circled, .line').forEach(el => {
        // Inject SVG based on class
        if (el.classList.contains('circled')) {
            el.innerHTML += `
        <svg class="circle-draw" width="643" height="147" viewBox="0 0 643 147" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M169.891 136.977C234.308 141.236 298.9 137.365 363.145 132.034C435.192 125.352 507.185 117.555 578.705 106.574C595.823 103.291 661.839 96.5236 619.816 73.5988C584.977 55.7026 545.571 49.9902 507.809 41.1177C468.165 33.5396 428.168 28.6999 388.023 25.1753C388.108 25.1712 388.193 25.1881 388.278 25.205C388.278 25.205 388.3 25.204 388.534 25.2347C340.28 23.2663 291.856 22.5509 243.703 26.9693C191.393 30.7259 139.827 41.0489 87.8229 47.1532C68.4964 51.9994 -2.89302 78.6475 9.86414 105.153C22.0963 126.537 141.462 134.737 169.913 136.997L169.891 136.977ZM262.226 146.455C214.255 147.658 165.788 146.079 118.166 140.578C97.9793 138.21 77.8197 135.524 57.8078 131.965C38.6126 127.376 1.84861 124.213 3.0334e-05 99.3482C5.50271 54.3791 99.7119 34.6539 137.377 27.6887C179.02 20.7403 220.914 15.4883 262.747 9.83845C297.785 4.94228 332.891 0.148254 368.331 -1.84769e-06C335.811 8.40154 302.424 12.9006 269.129 17.1C358.457 12.1899 448.414 18.8725 535.624 39.0213C567.919 46.8106 607.706 53.4115 634.342 73.9444C662.497 101.343 606.892 110.366 588.293 113.236C564.919 117.056 541.475 120.289 517.975 123.272C433.031 133.938 347.825 143.14 262.247 146.454L262.226 146.455Z" fill="none" stroke="#EFC0D4" stroke-width="3"/>
        </svg>`;
        } else if (el.classList.contains('line')) {
            el.innerHTML += `
        <svg class="line-draw" id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 390 46">
          <defs>
            <clipPath id="clippath">
              <rect x="17.2" y="-57.6" width="355" height="160.4" transform="translate(10.2 88.6) rotate(-26.3)"/>
            </clipPath>
          </defs>
          <g clip-path="url(#clippath)">
            <path d="M4.7,30.7C24.6-1.7,187.4,5.4,228.2,5.8c42.7,1.1,85.5,1.2,128.2.4,10.2.2,20.5,1.4,30.3,4.3-9.9,1.4-19.9,2.7-30,2.7-66.1-.7-132.2-4.2-198.3-3.5-40.9.6-82.3,2.3-122.1,12.4-7.5,2-15.1,3.5-22.6,5.5-2.7,1-6.3,1.1-8.2,3.4.2.4.7.5,1,.6-.7.2-1.7,0-1.8-.8Z" fill="none" stroke="#EFC0D4" stroke-width="3"/>
            <path d="M7.3,44.2c12.5-7.9,27.4-11,41.8-13.3,21.4-3.3,43.2-6.1,64.8-8,44.5-4.2,89.2-4.4,133.8-3.1,21.2.6,42.3,1.3,63.4,2.2,14.1.6,28.3.8,42.1,4.2,3.3.7,6.6,1.6,9.8,2.5-10.5,1.5-20.8,2.1-31.1,1.7-63.8-4.8-127.8-8.1-191.7-3.7-24.9,2.1-49.8,4.5-74.5,8.8-10,1.6-20,3.6-30,5.5-9.4,1.6-18.9,2-28.4,3.2h0Z" fill="none" stroke="#EFC0D4" stroke-width="3"/>
          </g>
        </svg>`;
        }

        // Animate SVG path drawing
        // el.querySelectorAll('path').forEach(path => {
        //     const length = path.getTotalLength();
        //     gsap.set(path, { strokeDasharray: length, strokeDashoffset: length });
        //
        //     gsap.to(path, {
        //         strokeDashoffset: 0,
        //         duration: 2,
        //         delay: 2, // ← wait 2 seconds before starting
        //         ease: "power2.out",
        //         scrollTrigger: {
        //             trigger: el,
        //             start: "top 80%",
        //             toggleActions: "play none none reverse"
        //         }
        //     });
        // });

    });
}

document.addEventListener('DOMContentLoaded', initBracketSVGs);
