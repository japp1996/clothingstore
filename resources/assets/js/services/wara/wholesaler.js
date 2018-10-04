import waraService from './wara'

const whosalerService = {}

whosalerService.store = function (data) {
    return waraService.post('admin/wholesalers', data)
        .then(res => res.data)
}

export default whosalerService


