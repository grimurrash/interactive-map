import map from '~/lib/map'

import stages from '~/consts/stages'

const returnState = function ({districts, settings}) {
    return {
        districts,
        settings
    }
}

export default (store) => {
    store.watch(returnState,
        function (value) {
            if (value.settings.loadedMap && stages.district.indexOf(value.settings.stage) > -1 && value.districts.current &&
                !value.settings.loading) {
                map.clearPoints()
                map.hideBalloons()

                map.setPolygonVisible(value.districts.current.polygons)

                map.drawPoints(value.districts.current.points)
            }
        }, {
            deep: true,
            immediate: true
        })
}
