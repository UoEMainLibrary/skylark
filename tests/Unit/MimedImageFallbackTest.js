import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import test from 'node:test';
import { runInNewContext } from 'node:vm';

const script = readFileSync(new URL('../../public/collections/mimed/js/record-images.js', import.meta.url), 'utf8');

function run(thumbnails = [], viewers = []) {
    runInNewContext(script, {
        URL,
        document: { querySelectorAll: selector => selector === '.thumbnail-image' ? thumbnails : viewers },
    });
}

function thumbnail(complete, naturalWidth) {
    const events = {};
    const link = { removed: false, remove() { this.removed = true; } };
    const placeholder = { removed: false, remove() { this.removed = true; } };
    const image = { complete, naturalWidth, closest: () => link, addEventListener: (name, callback) => { events[name] = callback; } };
    const container = { querySelector: selector => selector === 'img' ? image : placeholder };
    return { container, events, link, placeholder };
}

for (const cached of [false, true]) {
    test(`removes a failed thumbnail link and placeholder (cached=${cached})`, () => {
        const image = thumbnail(cached, 0);
        run([image.container]);
        if (!cached) image.events.error();
        assert.equal(image.link.removed, true);
        assert.equal(image.placeholder.removed, true);
    });

    test(`keeps a successful thumbnail link (cached=${cached})`, () => {
        const image = thumbnail(cached, 100);
        run([image.container]);
        if (!cached) image.events.load();
        assert.equal(image.link.removed, false);
        assert.equal(image.placeholder.removed, true);
    });
}

function viewer(initialManifest, ready = true) {
    const manifestUrl = 'https://id.collections.ed.ac.uk/ark:/12345/example';
    let manifest = initialManifest;
    let listener;
    let unsubscribed = false;
    const events = {};
    const store = {
        getState: () => ({ manifests: { [manifestUrl]: manifest } }),
        subscribe: callback => { listener = callback; return () => { unsubscribed = true; }; },
    };
    const frame = {
        src: 'https://skylark.test/mimed/mirador?manifest=' + encodeURIComponent(manifestUrl),
        contentWindow: ready ? { mirador: { store } } : {},
        addEventListener: (name, callback) => { events[name] = callback; },
    };
    const container = { removed: false, querySelector: () => frame, remove() { this.removed = true; } };
    return {
        container,
        update(value) { manifest = value; listener(); },
        load() { frame.contentWindow.mirador = { store }; events.load(); },
        unsubscribed: () => unsubscribed,
    };
}

for (const [label, manifest] of Object.entries({
    'failed request': { error: '404', isFetching: false },
    'empty v3 manifest': { json: { items: [] } },
    'empty v2 manifest': { json: { sequences: [{ canvases: [] }] } },
    'invalid manifest': { json: {} },
})) {
    test(`removes the viewer and its links for ${label}`, () => {
        const item = viewer(manifest);
        run([], [item.container]);
        assert.equal(item.container.removed, true);
        assert.equal(item.unsubscribed(), true);
    });
}

for (const [label, manifest] of Object.entries({
    'pending request': { isFetching: true },
    'v3 manifest': { json: { items: [{ id: 'canvas' }] } },
    'v2 manifest': { json: { sequences: [{ canvases: [{ '@id': 'canvas' }] }] } },
})) {
    test(`keeps the viewer for ${label}`, () => {
        const item = viewer(manifest);
        run([], [item.container]);
        assert.equal(item.container.removed, false);
    });
}

test('observes an iframe that loads later and removes a subsequently failed manifest', () => {
    const item = viewer({ isFetching: true }, false);
    run([], [item.container]);
    item.load();
    assert.equal(item.container.removed, false);
    item.update({ error: 'Network error', isFetching: false });
    assert.equal(item.container.removed, true);
    assert.equal(item.unsubscribed(), true);
});
