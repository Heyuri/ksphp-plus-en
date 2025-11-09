(function() {
    'use strict';

    // Language detection
    const isJapanese = navigator.language.startsWith('ja');
    const EMBED_TEXT = isJapanese ? '［埋め込み］' : '[Embed]';
    const CLOSE_TEXT = isJapanese ? '［閉じる］' : '[Close]';

    // Function to handle link modification
    function modifyLinks() {
        const postContents = document.querySelectorAll('.contents pre.msgnormal, .msgtree .ngline');

        postContents.forEach(postContent => {
            // Select all possible video links (extend this as more services are added)
            const links = postContent.querySelectorAll(
                'a[href*="youtube.com/watch?v="], a[href*="youtu.be/"], a[href*="nicovideo.jp/watch/"], a[href*="nico.ms/"]'
            );

            links.forEach(link => {
                // Extract video info
                const info = getVideoInfo(link.href);
                if (!info) return;

                // Create the [Embed] button
                const embedLink = document.createElement('a');
                embedLink.textContent = EMBED_TEXT;
                embedLink.href = 'javascript:void(0)';
                embedLink.style.cursor = 'pointer';
                embedLink.style.color = getComputedStyle(link).color;
                embedLink.style.textDecoration = 'underline';
                embedLink.style.marginLeft = '5px';

                // Create a wrapper for the embedded content
                const embedWrapper = document.createElement('div');
                embedWrapper.style.marginTop = '5px';

                // Thumbnail preview
                let hoverTimeout;
                const thumbnail = document.createElement('img');
                thumbnail.style.position = 'absolute';
                thumbnail.style.display = 'none';
                thumbnail.style.border = '1px solid #ccc';
                thumbnail.style.maxWidth = '200px';
                thumbnail.style.zIndex = '9999';
                document.body.appendChild(thumbnail);

                // Thumbnail hover behavior
                embedLink.addEventListener('mouseenter', () => {
                    if (embedLink.textContent === EMBED_TEXT) {
                        hoverTimeout = setTimeout(() => {
                            const thumbnailUrl = getThumbnailUrl(info);
                            if (thumbnailUrl) {
                                thumbnail.src = thumbnailUrl;
                                thumbnail.style.display = 'block';
                                const rect = embedLink.getBoundingClientRect();
                                thumbnail.style.top = `${rect.bottom + window.scrollY + 5}px`;
                                thumbnail.style.left = `${rect.left + window.scrollX + 5}px`;
                            }
                        }, 500);
                    }
                });

                embedLink.addEventListener('mouseleave', () => {
                    clearTimeout(hoverTimeout);
                    thumbnail.style.display = 'none';
                });

                // Toggle embed on click
                embedLink.addEventListener('click', () => {
                    if (embedLink.textContent === EMBED_TEXT) {
                        const embedUrl = getEmbedUrl(info);
                        if (embedUrl) {
                            const iframe = document.createElement('iframe');
                            iframe.width = '560';
                            iframe.height = '315';
                            iframe.src = embedUrl;
                            iframe.frameBorder = '0';
                            iframe.allowFullscreen = true;

                            embedWrapper.appendChild(iframe);
                            link.parentElement.insertBefore(embedWrapper, link.nextSibling.nextSibling);
                            embedLink.textContent = CLOSE_TEXT;
                        }
                    } else if (embedLink.textContent === CLOSE_TEXT) {
                        embedWrapper.innerHTML = '';
                        embedLink.textContent = EMBED_TEXT;
                    }
                    thumbnail.style.display = 'none';
                });

                // Insert the [Embed] button next to the link
                link.after(embedLink);
            });
        });
    }

    // Utility function to extract video info
    function getVideoInfo(url) {
        let match;

        switch (true) {
            // Case: YouTube
            case /youtube\.com\/watch\?v=|youtu\.be\//.test(url):
                match = url.match(/(?:youtube\.com\/.*v=|youtu\.be\/)([^&?/]+)/);
                return match ? { platform: 'yt', videoId: match[1] } : null;

            // Case: Nico Nico Douga
            case /nicovideo\.jp\/watch\/|nico\.ms\//.test(url):
                match = url.match(/(?:nicovideo\.jp\/watch\/|nico\.ms\/)([a-zA-Z0-9]+)/);
                return match ? { platform: 'nnd', videoId: match[1] } : null;

            default:
                return null;
        }
    }

    // Function to get embed URL based on platform
    function getEmbedUrl(info) {
        switch (info.platform) {
            case 'yt':
                return `https://www.youtube.com/embed/${info.videoId}`;
            case 'nnd':
                return `https://embed.nicovideo.jp/watch/${info.videoId}`;
            default:
                return null;
        }
    }

    // Function to get thumbnail URL based on platform
    function getThumbnailUrl(info) {
        switch (info.platform) {
            case 'yt':
                return `https://img.youtube.com/vi/${info.videoId}/0.jpg`;
            case 'nnd':
                const numericId = info.videoId.replace(/^\D+/, ''); // Extract numeric part
                return `https://nicovideo.cdn.nimg.jp/thumbnails/${numericId}/${numericId}`;
            default:
                return null;
        }
    }

    // Run the script
    modifyLinks();
})();
