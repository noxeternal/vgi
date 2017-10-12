// eslint-disable-next-line no-unused-vars
class vgAdd {
  constructor ($scope, $http, enumData) {
    this.scope = $scope
    this.http = $http
    this.enumData = enumData
    this.refreshEnumData()

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
    let style = this.enumData.styles.find((style) => style.name === this.style)
    if (style) return style.text
  }

  refreshEnumData () {
    this.enumData.refresh()
  }

  addGame (game) {
    if (this.scope.addGameForm.$valid) {
      if (this.style === '') this.style = 0
      if (this.box === '') this.box = 0
      if (this.manual === '') this.manual = 0

      game = {
        action: 'add',
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

  editGame () {
    // this.editGameID = parseInt(this.editGameID)
    if (this.editGameID) {
      this.currentGame = this.enumData.games.find(g => this.editGameID === g.id)
      console.log(this.currentGame)
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
