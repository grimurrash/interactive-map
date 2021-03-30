import map from '~/lib/map'

import stages from "~/consts/stages";

const returnState = function ({ museums, settings }) {
    return {
        museums,
        settings
    }
}

export default (store) => {
    store.watch(returnState,
        function (value) {
            if (value.settings.loadedMap && stages.museum.indexOf(value.settings.stage) > -1 && value.museums.current &&
                !value.settings.loading) {
                map.hideBalloons()
                map.clearPoints()

                map.setPolygonVisible(false)
                map.drawPoints([value.museums.current], false)

               // map.openBalloon(value.museums.current.info.id)
            }
        }, {
            deep: true,
            immediate: true
        })
}
