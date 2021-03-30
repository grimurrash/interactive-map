export default {
    install: function (Vue, watchers) {
        const watch = {}

        const onCreated = Object.keys(watchers).map((key) => {
            watch[key] = function (_new, _old) {
                if (this === this.$root) {
                    watchers[key].call(this, _new, _old)
                }
            }

            return watch[key]
        })
        Vue.mixin({
            watch,
            created() {
                onCreated.forEach((func) => {
                    func.bind(this)
                })
            }
        })
    }
}
