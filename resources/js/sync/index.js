import ClearStore from './ClearStore'
import Filters from './Filters'
import District from './DIstrict'
import DistrictList from './DistrictList'
import Museum from './Museum'
import Search from './Search'
import Stage from './Stage'

const modules = [
    Stage,
    Filters,
    Search,
    DistrictList,
    District,
    Museum,
    ClearStore
]

const sync = {}
let array = []
array.concat(
    Object.keys(ClearStore),
    Object.keys(Filters),
    Object.keys(District),
    Object.keys(DistrictList),
    Object.keys(Museum),
    Object.keys(Search),
    Object.keys(Stage)
)
    .sort()
    .filter((v, i, a) => v !== a[i + 1])
    .forEach((key) => {
        sync[key] = function (_new, _old) {
            modules.forEach((mod) => {
                mod[key].call(this, _new, _old)
            })
        }
    })

export default sync