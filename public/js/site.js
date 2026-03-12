document.addEventListener("DOMContentLoaded", () => {
    const revealTargets = Array.from(document.querySelectorAll(".reveal"));

    if (revealTargets.length) {
        if (!("IntersectionObserver" in window)) {
            revealTargets.forEach((node) => node.classList.add("is-visible"));
        } else {
            const observer = new IntersectionObserver(
                (entries, obs) => {
                    entries.forEach((entry) => {
                        if (!entry.isIntersecting) {
                            return;
                        }

                        entry.target.classList.add("is-visible");
                        obs.unobserve(entry.target);
                    });
                },
                {
                    threshold: 0.12,
                    rootMargin: "0px 0px -40px 0px",
                }
            );

            revealTargets.forEach((node) => observer.observe(node));
        }
    }

    const dropzones = Array.from(document.querySelectorAll("[data-gallery-dropzone]"));
    dropzones.forEach((dropzone) => {
        const inputId = dropzone.getAttribute("data-target-input");
        const previewId = dropzone.getAttribute("data-preview-target");
        const input = inputId ? document.getElementById(inputId) : null;
        const preview = previewId ? document.getElementById(previewId) : null;

        if (!(input instanceof HTMLInputElement) || input.type !== "file") {
            return;
        }

        const renderPreviews = () => {
            if (!(preview instanceof HTMLElement)) {
                return;
            }

            const files = Array.from(input.files || []);
            preview.innerHTML = "";

            files.forEach((file, index) => {
                const col = document.createElement("div");
                col.className = "col";

                const card = document.createElement("div");
                card.className = "card border-0 shadow-sm h-100";

                const img = document.createElement("img");
                img.className = "card-img-top gallery-upload-preview";
                img.alt = file.name;
                img.src = URL.createObjectURL(file);
                img.onload = () => URL.revokeObjectURL(img.src);

                const body = document.createElement("div");
                body.className = "card-body p-2";

                const name = document.createElement("p");
                name.className = "small mb-1 text-truncate";
                name.textContent = file.name;

                const badge = document.createElement("span");
                badge.className = index === 0 ? "badge text-bg-primary" : "badge text-bg-secondary";
                badge.textContent = index === 0 ? "Featured" : "Image";

                body.appendChild(name);
                body.appendChild(badge);
                card.appendChild(img);
                card.appendChild(body);
                col.appendChild(card);
                preview.appendChild(col);
            });
        };

        dropzone.addEventListener("click", () => input.click());

        ["dragenter", "dragover"].forEach((eventName) => {
            dropzone.addEventListener(eventName, (event) => {
                event.preventDefault();
                dropzone.classList.add("is-dragover");
            });
        });

        ["dragleave", "drop"].forEach((eventName) => {
            dropzone.addEventListener(eventName, (event) => {
                event.preventDefault();
                dropzone.classList.remove("is-dragover");
            });
        });

        dropzone.addEventListener("drop", (event) => {
            const droppedFiles = event.dataTransfer?.files;
            if (!droppedFiles?.length) {
                return;
            }

            const transferable = new DataTransfer();
            Array.from(droppedFiles).forEach((file) => {
                if (file.type.startsWith("image/")) {
                    transferable.items.add(file);
                }
            });

            input.files = transferable.files;
            renderPreviews();
        });

        input.addEventListener("change", renderPreviews);
        renderPreviews();
    });
});
