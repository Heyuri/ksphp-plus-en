(function() {
    'use strict';

    // Function to handle link modification
    function modifyLinks() {
        const postContents = document.querySelectorAll('.contents pre.msgnormal, .msgtree .ngline');

        postContents.forEach(postContent => {
            const links = postContent.querySelectorAll('a[href*="youtube.com/watch?v="], a[href*="youtu.be/"]');

            links.forEach(link => {
                const parentLine = link.closest('span.q') || link.parentElement;

                const embedLink = document.createElement('a');
                embedLink.textContent = '[Embed]';
                embedLink.href = 'javascript:void(0)';
                embedLink.style.cursor = 'pointer';

                // Inherit styles from the link for color only
                embedLink.style.color = getComputedStyle(link).color;
                embedLink.style.textDecoration = 'underline';

                // Add margin-left to ensure space between the link and the [Embed] button
                embedLink.style.marginLeft = '5px';

                // Create a wrapper for the embed
                const embedWrapper = document.createElement('div');
                embedWrapper.style.marginTop = '5px'; // Add some spacing between the link and the embed

                let hoverTimeout;
                const thumbnail = document.createElement('img');
                thumbnail.style.position = 'absolute';
                thumbnail.style.display = 'none';
                thumbnail.style.border = '1px solid #ccc';
                thumbnail.style.maxWidth = '200px';
                thumbnail.style.zIndex = '9999';
                document.body.appendChild(thumbnail);

                embedLink.addEventListener('mouseenter', (e) => {
                    if (embedLink.textContent === '[Embed]') {
                        hoverTimeout = setTimeout(() => {
                            const videoId = getVideoId(link.href);
                            if (videoId) {
                                const thumbnailUrl = `https://img.youtube.com/vi/${videoId}/0.jpg`;
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

                embedLink.addEventListener('click', () => {
                    if (embedLink.textContent === '[Embed]') {
                        // Embed the video
                        const videoUrl = link.href.replace('watch?v=', 'embed/');
                        const iframe = document.createElement('iframe');
                        iframe.width = '560';
                        iframe.height = '315';
                        iframe.src = videoUrl;
                        iframe.frameBorder = '0';
                        iframe.allow = 'autoplay; encrypted-media';
                        iframe.allowFullscreen = true;

                        embedWrapper.appendChild(iframe);
                        link.parentElement.insertBefore(embedWrapper, link.nextSibling.nextSibling); // Place the embed below the link
                        embedLink.textContent = '[Close]';
                    } else if (embedLink.textContent === '[Close]') {
                        // Remove the embed
                        embedWrapper.innerHTML = '';
                        embedLink.textContent = '[Embed]';
                    }
                    thumbnail.style.display = 'none';
                });

                link.after(embedLink);
            });
        });
    }

    // Utility function to extract video ID from YouTube URL
    function getVideoId(url) {
         // Match both youtube.com and youtu.be URLs and extract the video ID
         const match = url.match(/(?:youtube\.com\/.*v=|youtu\.be\/)([^&?/]+)/);
         return match ? match[1] : null;
    }

    // Run the script
    modifyLinks();
})();
