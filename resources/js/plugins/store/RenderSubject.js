import map from '~/lib/map'

import stages from "~/consts/stages";

const returnState = function ({ subjects, settings }) {
    return {
        subjects,
        settings
    }
}

export default (store) => {
    store.watch(returnState,
        function (value) {
            if (value.settings.loadedMap && stages.subject.indexOf(value.settings.stage) > -1 && value.subjects.current &&
                !value.settings.loading) {
                map.hideBalloons()
                map.clearPoints()

                map.setPolygonVisible(false)
                map.drawPoints([value.subjects.current], false)
            }
        }, {
            deep: true,
            immediate: true
        })
}
