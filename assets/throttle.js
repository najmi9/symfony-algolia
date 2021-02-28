function throttle(callback, wait, immediate = false) {
    let timeout = null 
    let initialCall = true
    
    return function() {
      const callNow = immediate && initialCall
      const next = () => {
        callback.apply(this, arguments)
        timeout = null
      }
      
      if (callNow) { 
        initialCall = false
        next()
      }
  
      if (!timeout) {
        timeout = setTimeout(next, wait)
      }
    }
  }
  
  /**
   * Normal event
   * event      | |      |
   * time     ----------------
   * callback   | |      |
   * 
   * Call search at most once per 300ms while keydown
   * keydown     | |     |  |
   * time     -----------------
   * search          |       | 
   *             |300|   |300|
   */
   
export default throttle;

