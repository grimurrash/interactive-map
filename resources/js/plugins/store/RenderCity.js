import map from '~/lib/map'

import stages from '~/consts/stages'

const returnState = function ({settings, districts }) {
    return {
        districts,
        settings
    }
}

export default (store) => {
    store.watch(returnState,
        function (value) {
            if (value.settings.loadedMap && stages.city.indexOf(value.settings.stage) > -1 && !value.settings.loading) {
                map.clearPoints()

                map.setPolygonVisible()

                map.drawPoints(value.districts.points, true)
            }
        }, {
            deep: true,
            immediate: true
        })
}
