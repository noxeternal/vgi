// eslint-disable-next-line no-unused-vars
class vgEdit {
  constructor ($rootScope, $scope, $http, enumData, vgEditFactory) {
    this.root = $rootScope
    this.scope = $scope
    this.http = $http
    this.enumData = enumData
    this.refreshEnumData()
    this.editFactory = vgEditFactory

    this.actionURL = 'server/actions.php'
    // this.actionURL = 'https://noxeternal.net/vg/inc/actions.php'
    this.link = {
      parent: this,
      string: '',
      get displayString () {
        let thisConsole = false
        if (this.parent.console) { thisConsole = this.parent.enumData.consoles.find(con => con.id.toString() === this.parent.console) }

        if (thisConsole && this.string) { return `https://www.pricecharting.com/game/${thisConsole.link}/${this.string}` } else { return false }
      }
    }
  }

  dispCategory () {
    let cat = this.enumData.categories.find(cat => cat.id.toString() === this.category)
    if (cat) return cat.text
  }
  dispConsole () {
    let con = this.enumData.consoles.find(con => con.id.toString() === this.console)
    if (con) return con.text
  }
  dispCondition () {
    let cond = this.enumData.conditions.find((cond) => cond.id.toString() === this.condition)
    if (cond) return cond.text
  }
  dispStyle () {
    let style = this.enumData.styles.find((style) => style.id.toString() === this.style)
    if (style) return style.text
  }

  refreshEnumData () {
    this.enumData.refresh()
  }

  loadGame () {
    if (this.editFactory.get()) {
      let game = this.enumData.games.find((game) => game.id === this.editFactory.get())
      this.name = game.name
      this.style = game.style
      this.link.string = game.link
      this.category = game.category
      this.console = game.console
      this.condition = game.condition
      this.box = game.box
      this.manual = game.manual
    }
  }

  editGame (game) {
    if (this.scope.addGameForm.$valid) {
      if (this.style === '') this.style = 0
      if (this.box === '') this.box = 0
      if (this.manual === '') this.manual = 0

      game = {
        action: 'edit',
        name: this.name,
        style: this.style,
        link: this.link.string,
        category: this.category,
        console: this.console,
        condition: this.condition,
        box: this.box,
        manual: this.manual
      }

      this.http.post(this.actionURL, game)
        .then(() => { this.resetForm() })
    } else {
      console.log('invalid form')
    }
  }

  resetForm () {
    this.name = ''
    this.style = 0
    this.link.string = ''
    this.category = ''
    this.console = ''
    this.condition = ''
    this.box = ''
    this.manual = ''
  }
}
