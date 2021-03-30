import map from '~/lib/map'

import stages from "~/consts/stages";

const returnState = function ({ search, settings }) {
    return {
        search,
        settings
    }
}

export default (store) => {
    store.watch(returnState,
        function (value) {
            if (value.settings.loadedMap && stages.search.indexOf(value.settings.stage) > -1 && value.search.list &&
                !value.settings.loading) {
                map.hideBalloons()
                map.setPolygonVisible(false)
                map.clearPoints()

                map.drawPoints(value.search.list)
            }
        }, {
            deep: true,
            immediate: true
        })
}
