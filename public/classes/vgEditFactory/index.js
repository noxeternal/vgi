// eslint-disable-next-line no-unused-vars
class vgEditFactory {
  constructor ($rootScope) {
    this.root = $rootScope
  }

  set (id) {
    this.root.editId = id
  }

  get () {
    return this.root.editId
  }
}
