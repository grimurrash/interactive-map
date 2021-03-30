const state = {
    mapConfig: {
        settings: {
            apiKey: '6e34736c-2933-4bcc-9407-5da11fd2d9fa',
            lang: 'ru_RU',
            version: '2.1',
            load: 'package.map'
        },
        center: [55.755814, 37.617635],
        zoom: 11,
        controls: [],
        behaviors: ['drag', 'scrollZoom', 'dblClickZoom', 'multiTouch'],
        options: {
            minZoom: 9,
            maxZoom: 16,
            maxAnimationZoomDifference: 15,
            suppressMapOpenBlock: false,
            restrictMapArea: [
                [55, 36],
                [56.5, 39]
            ]
        }
    },
}

export default {
    actions: {},
    mutations: {},
    state,
    getters: {
        mapConfig: (state) => {
            return state.mapConfig
        }
    }
}
