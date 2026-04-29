document.addEventListener("DOMContentLoaded", () => {
    // Select2 только если есть селектор и библиотеки (страница контактов); иначе скрипт не падает на остальных URL
    const orderServiceSelect = document.querySelector(".select2-order-service");
    if (orderServiceSelect && window.jQuery && window.jQuery.fn && typeof window.jQuery.fn.select2 === "function") {
        const placeholder = orderServiceSelect.getAttribute("data-placeholder") || "Выберите услугу";
        window.jQuery(orderServiceSelect).select2({
            width: "100%",
            placeholder,
            // Поле поиска показываем только при достаточном числе опций — на коротком списке остаётся обычный вид
            minimumResultsForSearch: 6,
        });
    }

    const header = document.querySelector("[data-site-header]");
    const navToggle = document.querySelector("[data-nav-toggle]");
    const mainNav = document.querySelector("[data-main-nav]");

    const onScroll = () => {
        if (!header) return;
        header.classList.toggle("is-scrolled", window.scrollY > 20);
    };

    onScroll();
    window.addEventListener("scroll", onScroll);

    if (navToggle && mainNav) {
        navToggle.addEventListener("click", () => {
            mainNav.classList.toggle("open");
        });
            mainNav.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", () => {
            mainNav.classList.remove("open");
        });
    });
    }

    const filterRoot = document.querySelector("[data-gallery-filters]");
    if (filterRoot) {
        const buttons = filterRoot.querySelectorAll("[data-filter]");
        const items = Array.from(document.querySelectorAll(".gallery-all [data-category]"));
        const loadMoreButton = document.querySelector("[data-gallery-load-more]");
        const pageSize = 12;
        let activeFilter = "all";
        let visibleCount = pageSize;

        const getFilteredItems = () =>
            items.filter((item) => {
                const category = item.getAttribute("data-category");
                return activeFilter === "all" || category === activeFilter;
            });

        const applyGalleryVisibility = () => {
            const filteredItems = getFilteredItems();

            items.forEach((item) => {
                const category = item.getAttribute("data-category");
                const inFilter = activeFilter === "all" || category === activeFilter;
                if (!inFilter) {
                    item.classList.add("is-hidden");
                    return;
                }

                const indexInFilter = filteredItems.indexOf(item);
                const shouldShow = indexInFilter >= 0 && indexInFilter < visibleCount;
                item.classList.toggle("is-hidden", !shouldShow);
            });

            if (!loadMoreButton) return;
            const hasMore = filteredItems.length > visibleCount;
            loadMoreButton.hidden = !hasMore;
            loadMoreButton.disabled = !hasMore;
        };

        if (loadMoreButton) {
            loadMoreButton.addEventListener("click", () => {
                visibleCount += pageSize;
                applyGalleryVisibility();
            });
        }

        buttons.forEach((button) => {
            button.addEventListener("click", () => {
                const filter = button.getAttribute("data-filter") || "all";

                buttons.forEach((btn) => btn.classList.remove("active"));
                button.classList.add("active");
                activeFilter = filter;
                visibleCount = pageSize;
                applyGalleryVisibility();
            });
        });

        applyGalleryVisibility();
    }

    const serviceFilterRoot = document.querySelector("[data-services-filters]");
    if (serviceFilterRoot) {
        const serviceButtons = serviceFilterRoot.querySelectorAll("[data-service-filter]");
        const serviceItems = Array.from(document.querySelectorAll(".services-list [data-service-category]"));
        const serviceLoadMoreButton = document.querySelector("[data-service-load-more]");
        const servicePageSize = 6;
        let activeServiceFilter = "all";
        let visibleServiceCount = servicePageSize;

        const getFilteredServiceItems = () =>
            serviceItems.filter((item) => {
                const category = item.getAttribute("data-service-category");
                return activeServiceFilter === "all" || category === activeServiceFilter;
            });

        const applyServiceVisibility = () => {
            const filteredItems = getFilteredServiceItems();

            serviceItems.forEach((item) => {
                const category = item.getAttribute("data-service-category");
                const inFilter = activeServiceFilter === "all" || category === activeServiceFilter;
                if (!inFilter) {
                    item.classList.add("is-hidden");
                    return;
                }

                const indexInFilter = filteredItems.indexOf(item);
                const shouldShow = indexInFilter >= 0 && indexInFilter < visibleServiceCount;
                item.classList.toggle("is-hidden", !shouldShow);
            });

            if (!serviceLoadMoreButton) return;
            const hasMore = filteredItems.length > visibleServiceCount;
            serviceLoadMoreButton.hidden = !hasMore;
            serviceLoadMoreButton.disabled = !hasMore;
        };

        if (serviceLoadMoreButton) {
            serviceLoadMoreButton.addEventListener("click", () => {
                visibleServiceCount += servicePageSize;
                applyServiceVisibility();
            });
        }

        serviceButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const filter = button.getAttribute("data-service-filter") || "all";

                serviceButtons.forEach((btn) => btn.classList.remove("active"));
                button.classList.add("active");
                activeServiceFilter = filter;
                visibleServiceCount = servicePageSize;
                applyServiceVisibility();
            });
        });

        applyServiceVisibility();
    }

    const lightboxRoot = document.querySelector("[data-photo-lightbox]");
    const lightboxImg = document.getElementById("photo-lightbox-img");
    const lightboxCaption = document.getElementById("photo-lightbox-caption");

    if (lightboxRoot && lightboxImg && lightboxCaption) {
        const openLightbox = (src, altText) => {
            lightboxImg.src = src;
            lightboxImg.alt = altText || "";
            // textContent для подписи: произвольный alt из данных не разбирается как HTML (в т.ч. при символах < >)
            lightboxCaption.textContent = altText || "";
            lightboxRoot.hidden = false;
            document.body.style.overflow = "hidden";
        };

        const closeLightbox = () => {
            lightboxRoot.hidden = true;
            lightboxImg.src = "/images/placeholders/placeholder.jpg";
            lightboxImg.alt = "";
            lightboxCaption.textContent = "";
            document.body.style.overflow = "";
        };

        document.querySelectorAll("[data-lightbox-src]").forEach((trigger) => {
            trigger.addEventListener("click", (e) => {
                const src = trigger.getAttribute("data-lightbox-src");
                if (!src) return;
                e.preventDefault();
                const altText = trigger.getAttribute("data-lightbox-alt") || "";
                openLightbox(src, altText);
            });
        });

        lightboxRoot.querySelectorAll("[data-photo-lightbox-close]").forEach((el) => {
            el.addEventListener("click", (e) => {
                e.preventDefault();
                closeLightbox();
            });
        });

        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape" && !lightboxRoot.hidden) {
                closeLightbox();
            }
        });
    }
});
