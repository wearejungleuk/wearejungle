// Move the in-blog ad bar into the middle of the article body.
// The ad is rendered after .bard by Antlers, then relocated here so it
// sits between top-level blocks roughly halfway through the article.

function moveBlogAdBar() {
    const host = document.querySelector('.bard[data-ad-host]');
    const ad = document.querySelector('.blog-ad-bar');
    if (!host || !ad) return;
    if (host.contains(ad)) return;

    const blocks = Array.from(host.children);
    if (blocks.length < 2) {
        host.appendChild(ad);
        return;
    }

    const midIndex = Math.floor(blocks.length / 2);
    blocks[midIndex].after(ad);
}

document.addEventListener('DOMContentLoaded', moveBlogAdBar);
