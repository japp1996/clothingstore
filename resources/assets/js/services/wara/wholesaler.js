import waraService from './wara'

const whosalerService = {}

whosalerService.store = function (data) {
    return waraService.post('admin/wholesalers', data, {
        onUploadProgress: function( progressEvent ) {
            let percent = document.querySelector('#percent')
            percent.innerHTML = `${parseInt( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ))}%`
        }.bind(this)
    })
    .then(res => res.data)
}

whosalerService.destroy = function (id) {
    return waraService.delete(`admin/wholesalers/${id}`)
        .then(res => res.data)
}

export default whosalerService


