export default new class Map {
    constructor() {
        this.map = 'yaMap'
        this.markСoordinates = []
        this.init()
    }
    init() {
        const self = this
        ymaps.ready(function() {
            if(mapAddress) {
                ymaps.geocode(mapAddress).then(res => {
                    let coordinates = res.geoObjects.get(0).geometry.getCoordinates()
                    let map = new ymaps.Map(self.map, {
                        center: coordinates,
                        zoom: 12,
                        controls: ['zoomControl',  'fullscreenControl']
                    })
                    let mark = new ymaps.GeoObject({
                        geometry: {
                            type: "Point",
                            coordinates: coordinates
                        },
                        properties: {
                            hintContent: 'get box'
                        }
                    })
                    map.geoObjects.add(mark)
                })
            } else {
                let map = new ymaps.Map(self.map, {
                    center:  [55.76, 37.64],
                    zoom: 12,
                    controls: ['zoomControl',  'fullscreenControl']
                })
            }
        })
    }
}