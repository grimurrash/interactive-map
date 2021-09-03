import {bus} from "~/app"
import store from "~/store/index"
import stages from "~/consts/stages";

let map, ymaps, pointsObjectManager, polygonsObjectManager

export default {
    checkMobile() {
        let check = false;
        /* eslint-disable no-useless-escape */
        (function (a) {
            if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true
        })(navigator.userAgent || navigator.vendor || window.opera)
        return check
    },
    initMap: function (settings) {
        ymaps = window.ymaps

        return map ? Promise.resolve(map) : ymaps.ready().then(() => {
            map = new ymaps.Map('map', {
                center: settings.center,
                zoom: settings.zoom,
                controls: settings.controls,
                behaviors: settings.behaviors
            }, settings.options)

            map.controls.add('geolocationControl', {position: {right: '10px', top: '200px'}})
            map.controls.add('zoomControl', {position: {right: '10px', top: '250px'}})

            var customBalloonContentLayout = ymaps.templateLayoutFactory.createClass([
                '<ul class="clusterize_list">',
                // Выводим в цикле список всех геообъектов.
                '{% for geoObject in properties.geoObjects %}',
                '<li>' +
                '<a href="" data-objectId="{{ geoObject.properties.id }}" class="list_item">' +
                ' <b>{{ geoObject.properties.balloonContentHeader|raw }}</b> </a>' +
                '</li>',
                '{% endfor %}',
                '</ul>',
            ].join(''));

            $(document).on('click','ul.clusterize_list li>a.list_item', function (e) {
                e.preventDefault()
                const id = $(this)[0].getAttribute('data-objectId')
                const ob = pointsObjectManager.objects.getById(id)
                if (ob.internal) {
                    return
                }
                if (typeof ob.main === 'boolean') {
                    if (ob.main) {
                        bus.$emit('toDistrict', ob.id)
                    } else {
                        bus.$emit('toSubject', ob.id)
                    }
                }
            })

            pointsObjectManager = new ymaps.ObjectManager({
                // Чтобы метки начали кластеризоваться, выставляем опцию.
                clusterize: true,
                // ObjectManager принимает те же опции, что и кластеризатор.
                gridSize: 30,
                clusterDisableClickZoom: true,
                clusterOpenBalloonOnClick: true,
                // Устанавливаем собственный макет контента балуна.
                clusterBalloonContentLayout: customBalloonContentLayout,
                // Устанавливаем собственный макет.
                // clusterBalloonItemContentLayout: customItemContentLayout,
                // Устанавливаем режим открытия балуна.
                // В данном примере балун никогда не будет открываться в режиме панели.
                clusterBalloonPanelMaxMapArea: 0,
                // Устанавливаем размеры макета контента балуна (в пикселях).
                clusterBalloonMaxWidth: 300,
                clusterBalloonMaxHeight: 350,
                // Можно отключить отображение иконок геообъектов в списке.
                // В браузере Internet Explorer ниже 9й версии иконки никогда не будут отображаться.
                // clusterBalloonAccordionShowIcons: false
            })
            polygonsObjectManager = new ymaps.ObjectManager()


            pointsObjectManager.objects.events
                .add('click', function (e) {
                    const id = e.get('objectId')
                    const ob = pointsObjectManager.objects.getById(id)
                    if (ob.internal) {
                        return
                    }
                    if (typeof ob.main === 'boolean') {
                        if (ob.main) {
                            bus.$emit('toDistrict', ob.id)
                        } else {
                            bus.$emit('toSubject', ob.id)
                        }
                    }
                })
        })
    },
    setPolygonVisible: function (data) {
        let options = {}

        polygonsObjectManager.objects.each(function (ob) {
            if (ob.properties.name && ob.properties.name.indexOf('граница') !== -1 && ob.geometry.type === 'Polygon') {
                return
            }
            if (data) {
                // let out = _.find(data, function (item) {
                //   console.log(item)
                //   return parseInt(item) === parseInt(ob.id)
                // })

                // console.log(ob.id)

                const out = data.indexOf(ob.id) > -1

                // eslint-disable-next-line
                if (out) {
                    options.strokeWidth = 0.3
                    options.fillOpacity = 0.4
                } else {
                    options.strokeWidth = 0
                    options.fillOpacity = 0
                }
            } else {
                if (typeof data === 'boolean') {
                    options.strokeWidth = 0
                    options.fillOpacity = 0
                } else {
                    options.strokeWidth = 0.3
                    options.fillOpacity = 0.6
                }
            }

            polygonsObjectManager.objects.setObjectOptions(ob.id, options)
        })
    },
    openBalloon: function (id) {
        pointsObjectManager.objects.balloon.open(id)
    },
    hideBalloons: function () {
        pointsObjectManager.objects.balloon.close()
    },
    clearPoints: function (id, full = false) {
        const selected = id || store.state.selected
        pointsObjectManager.objects.each(function (ob) {
            if ((ob.geometry && ob.geometry.type === 'Point' && ob.id !== selected) || full) {
                pointsObjectManager.remove(ob)
            }
        })
    },
    /**
     * @param {[{color: string, coordinates: number[], name: string, id: string, main: string, mrsd: number, zonal: number}]} polygons
     */
    drawPolygons: function (polygons) {
        let obj = {
            type: 'FeatureCollection',
            features: []
        }
        polygons.map(function (pol) {
            let options = {
                fillColor: pol.color,
                strokeColor: '#000000'
            }


            if (store.state.settings.stage === stages.city) {
                options.strokeWidth = 0.3
                options.fillOpacity = 0.6
            } else {
                options.strokeWidth = 0
                options.fillOpacity = 0
            }


            options.zIndex = 10
            options.zIndexHover = 10

            obj.features.push({
                type: 'Feature',
                id: parseInt(pol.id),
                properties: {
                    name: pol.name,
                    hintContent: pol.name,
                    zonal: pol.zonal
                },
                geometry: {
                    type: 'Polygon',
                    coordinates: pol.coordinates
                },
                options: options
            })
        })
        polygonsObjectManager.add(obj)
        map.geoObjects.add(polygonsObjectManager)
    },
    drawPoints: function (points, main = false, internal = false) {
        let obj = {
            type: 'FeatureCollection',
            features: []
        }

        points.map(function (p) {
            let properties = {
                id: p.id,
                title: p.name
            }

            if (main) {
                properties.iconContent = p.subjectsCount
                properties.balloonContentHeader = `${p.shortName}<br/>`
                properties.balloonContentBody = `Музеев в ${p.shortName}: ${p.subjectsCount}`
            } else {
                properties.hintContent = p.name || p.title
                properties.balloonContentHeader = `${p.name || p.title}<br/>`
            }
            obj.features.push({
                type: 'Feature',
                id: p.id,
                main: main,
                internal: internal,
                geometry: {
                    type: 'Point',
                    coordinates: [parseFloat(p.Latitude), parseFloat(p.Longitude)],
                },
                properties,
                options: {
                    preset: main ? 'islands#blueCircleIcon' : 'islands#blueCircleDotIcon',
                    hideIconOnBalloonOpen: false,
                    hasBalloon: false
                }
            })
        })

        pointsObjectManager.add(obj)
        map.geoObjects.add(pointsObjectManager)
        this.setBounds(null, main)
    },
    setBounds(om = null, main = false) {
        let zoomMargin = [100, 0, 80, 300]
        if (main) {
            zoomMargin = [0, 200, 80, 0]
        }
        if (this.checkMobile()) {
            zoomMargin = [10, 10, 10, 10]
        }
        om = om || pointsObjectManager
        if (om.getBounds()) {
            const boundsParam = {
                checkZoomRange: true,
                zoomMargin: zoomMargin,
                duration: main ? 500 : 400,
                timingFunction: 'ease-in-out'
            }
            map.setBounds(om.getBounds(), boundsParam)
        }
    },
}
