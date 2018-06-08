// eslint-disable-next-line no-unused-vars
class vgDisplay {
  constructor ($rootScope, enumData, vgEditFactory) {
    this.root = $rootScope
    this.filters = [
      'console', 'condition', 'category'
    ]
    this.resetFilter()
    this.enumData = enumData
    this.editFactory = vgEditFactory
    this.editId = this.editFactory.get()

    this.refreshing = false

    this.refreshEnumData()
  }

  refreshEnumData () {
    this.refreshing = true
    this.enumData.refresh()
      .then(() => { this.refreshing = false })
  }

  resetFilter () {
    this.nameFilter = ''
    this.filters.forEach(f => {
      this[f + 'List'] = []
    })
    this.categoryList = 'Game'
  }

  showGames () {
    if (!this.enumData) return false

    let byConsole = []
    let filteredGames = this.gameFilter()

    this.enumData.consoles.forEach(con => {
      con.games = filteredGames.filter(game => {
        return game.console === con.text
      })
      byConsole.push(con)
    })

    let counts = []
    byConsole.forEach(con => {
      counts.push(con.games.length)
    })

    let longCount = Math.max.apply(null, counts)
    byConsole.forEach((con, i, byConsole) => {
      byConsole[i].blankLines = new Array(longCount - con.games.length)
    })

    return byConsole
  }

  gameFilter () {
    let games = this.enumData.games

    this.filters.forEach(f => {
      if (this[f + 'List'].length === 0 || (this[f + 'List'].length === 1 && this[f + 'List'].indexOf('') === 0)) { return true }

      games = games.filter(game => {
        return this[f + 'List'].indexOf(game[f]) >= 0
      })
    })

    if (this.nameFilter !== '') {
      games = games.filter(game => {
        return game.name.toLowerCase().indexOf(this.nameFilter.toLowerCase()) >= 0
      })
    }

    return games
  }

  getStyle (s) {
    let styles = this.enumData.styles
    let thisStyle = styles.find((style) => style.name === s)
    console.log(s + ' :: ' + thisStyle)
    return thisStyle
  }

  setEditGame (id) {
    console.log(id)
    this.editFactory.set(id)
  }
}
