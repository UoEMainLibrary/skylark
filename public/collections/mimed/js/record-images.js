(() => {
    document.querySelectorAll('.thumbnail-image').forEach(container => {
        const image = container.querySelector('img');
        const placeholder = container.querySelector('.thumbnail-placeholder');
        if (!image) return;

        const loaded = () => placeholder?.remove();
        const failed = () => {
            loaded();
            image.closest('a')?.remove();
        };

        image.addEventListener('load', loaded);
        image.addEventListener('error', failed);
        if (image.complete) {
            image.naturalWidth > 0 ? loaded() : failed();
        }
    });

    document.querySelectorAll('[data-mimed-viewer]').forEach(container => {
        const frame = container.querySelector('iframe');
        const manifestUrl = new URL(frame.src).searchParams.get('manifest');
        let unsubscribe;

        const observe = () => {
            unsubscribe?.();
            const store = frame.contentWindow.mirador?.store;
            if (!store) return;

            const check = () => {
                const manifest = store.getState().manifests[manifestUrl];
                if (!manifest || manifest.isFetching) return;

                const canvases = manifest.json?.items ?? manifest.json?.sequences?.[0]?.canvases;
                if (manifest.error || (manifest.json && !canvases?.length)) {
                    container.remove();
                    unsubscribe?.();
                }
            };

            unsubscribe = store.subscribe(check);
            check();
        };

        frame.addEventListener('load', observe);
        observe();
    });
})();
