(function() {
    'use strict';

    // Function to add the new checkbox
    function addCheckbox() {
        const smallDiv = document.querySelector('.small');
        if (smallDiv) {
            const label = document.createElement('label');
            label.setAttribute('for', 'enableThumbnails');
            label.textContent = 'Uploader thumbnails';
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'enableThumbnails';
            checkbox.accessKey = 'T';
            checkbox.value = 'checked';
            checkbox.title = 'Alt(+Shift)+T';
            checkbox.id = 'enableThumbnails';
            checkbox.checked = localStorage.getItem('enableThumbnails') !== 'false';

            smallDiv.insertBefore(label, smallDiv.querySelector('input[type="submit"]'));
            smallDiv.insertBefore(checkbox, smallDiv.querySelector('input[type="submit"]'));
        }
    }

    // Function to create the thumbnails
    function createThumbnail(url, originalUrl) {
        const anchor = document.createElement('a');
        anchor.href = originalUrl;
        anchor.target = '_blank';
        const img = document.createElement('img');
        img.src = url;
        img.setAttribute('loading', 'lazy'); // Add lazy loading
        img.style.maxHeight = '95px';
        img.style.maxWidth = '200px';
        img.style.margin = '5px';
        anchor.appendChild(img);
        return anchor;
    }

    // Function to check if the thumbnail exists
    function thumbnailExists(url) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open('HEAD', url, true);
            xhr.onload = () => {
                if (xhr.status === 200) {
                    resolve(true);
                } else {
                    resolve(false);
                }
            };
            xhr.onerror = () => resolve(false);
            xhr.send();
        });
    }

    // Function to get the thumbnail URL based on the original URL
    function getThumbnailUrl(url) {
        if (url.includes('/src/')) {
            return url.replace('/src/', '/thmb/').replace(/\.\w+$/, '_thumb.jpg');
        } else if (url.includes('/gsrc/')) {
            return url.replace('/gsrc/', '/gthmb/').replace(/\.\w+$/, '_thumb.jpg');
        } else {
            return null;
        }
    }

    // List of allowed file extensions
    const allowedExtensions = ['jpg', 'jpeg', 'bmp', 'webp', 'png', 'gif', 'mp4', 'webm'];

    // Function to handle the script functionality
    function runScript() {
        // Select all the post contents
        const postContents = document.querySelectorAll('.contents pre.msgnormal, .msgtree .ngline');

        // Process each post content
        postContents.forEach(postContent => {
            // Array to hold the heyuri links
            const heyuriLinks = [];

            // Get all the links in the post content
            const links = postContent.querySelectorAll('a');

            // Loop through all the links and find the ones pointing to up.heyuri.net with /src/ and not starting with >
            links.forEach(link => {
                const parentLine = link.closest('span.q') || link.parentElement;
                const lineContent = parentLine.textContent.trim();
                const previousSiblingText = link.previousSibling ? link.previousSibling.textContent.trim() : '';

                if ((!lineContent.startsWith('>') || !previousSiblingText.startsWith('>')) && 
                    link.href.includes('up.heyuri.net') && 
                    (link.href.includes('/src/') || link.href.includes('/msrc/') || link.href.includes('/gsrc/') || link.href.includes('/gemusrc/') || link.href.includes('/user/boards/'))) {
                    heyuriLinks.push(link.href);
                }
            });

            // Append the thumbnails at the end of the post
            if (heyuriLinks.length > 0) {
                const thumbContainer = document.createElement('div');
                thumbContainer.style.marginTop = '10px';

                heyuriLinks.forEach(async url => {
                    const extension = url.split('.').pop().toLowerCase();
                    if (allowedExtensions.includes(extension)) {
                        const thumbnailUrl = getThumbnailUrl(url);
                        if (thumbnailUrl) {
                            const isThumbnailAvailable = await thumbnailExists(thumbnailUrl);
                            if (isThumbnailAvailable) {
                                const thumb = createThumbnail(thumbnailUrl, url);
                                thumbContainer.appendChild(thumb);
                            } else if (![ '.webm', '.mp4' ].some(ext => url.endsWith(ext))) {
                                const thumb = createThumbnail(url, url);
                                thumbContainer.appendChild(thumb);
                            }
                        }
                    }
                });

                postContent.appendChild(thumbContainer);
            }
        });
    }

    // Initialize script
    function init() {
        addCheckbox();
        const checkbox = document.getElementById('enableThumbnails');
        if (checkbox) {
            checkbox.addEventListener('change', () => {
                const isChecked = checkbox.checked;
                localStorage.setItem('enableThumbnails', isChecked); // Save state
                if (isChecked) {
                    runScript();
                }
            });

            if (checkbox.checked) {
                runScript();
            }
        }
    }

    init();
})();
