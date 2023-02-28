<div class="container bootstrap snippets bootdeys">
    <div class="row">

        <div class="col-md-4 col-sm-6 content-card in">
            <div class="card-big-shadow">
                <div class="card card-just-text" data-background="color" data-color="green" data-radius="none">
                    <div class="content">
                        <h6 class="category"></h6>
                        <h4 class="title">Punch In</h4>
                        <p class="description"></p>
                    </div>
                </div> <!-- end card -->
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div id="clock"></div>
        </div>

        <div class="col-md-4 col-sm-6 content-card out">
            <div class="card-big-shadow">
                <div class="card card-just-text" data-background="color" data-color="yellow" data-radius="none">
                    <div class="content">
                        <h6 class="category"></h6>
                        <h4 class="title">Punch Out</h4>
                        <p class="description"></p>
                    </div>
                </div> <!-- end card -->
            </div>
        </div>

    </div>
</div>

<script>
//     var hoursContainer = document.querySelector('.hours')
// var minutesContainer = document.querySelector('.minutes')
// var secondsContainer = document.querySelector('.seconds')
// var tickElements = Array.from(document.querySelectorAll('.tick'))

// var last = new Date(0)
// last.setUTCHours(-1)

// var tickState = true

// function updateTime () {
//   var now = new Date
  
//   var lastHours = last.getHours().toString()
//   var nowHours = now.getHours().toString()
//   if (lastHours !== nowHours) {
//     updateContainer(hoursContainer, nowHours)
//   }
  
//   var lastMinutes = last.getMinutes().toString()
//   var nowMinutes = now.getMinutes().toString()
//   if (lastMinutes !== nowMinutes) {
//     updateContainer(minutesContainer, nowMinutes)
//   }
  
//   var lastSeconds = last.getSeconds().toString()
//   var nowSeconds = now.getSeconds().toString()
//   if (lastSeconds !== nowSeconds) {
//     //tick()
//     updateContainer(secondsContainer, nowSeconds)
//   }
  
//   last = now
// }

// function tick () {
//   tickElements.forEach(t => t.classList.toggle('tick-hidden'))
// }

// function updateContainer (container, newTime) {
//   var time = newTime.split('')
  
//   if (time.length === 1) {
//     time.unshift('0')
//   }
  
  
//   var first = container.firstElementChild
//   if (first.lastElementChild.textContent !== time[0]) {
//     updateNumber(first, time[0])
//   }
  
//   var last = container.lastElementChild
//   if (last.lastElementChild.textContent !== time[1]) {
//     updateNumber(last, time[1])
//   }
// }

// function updateNumber (element, number) {
//   //element.lastElementChild.textContent = number
//   var second = element.lastElementChild.cloneNode(true)
//   second.textContent = number
  
//   element.appendChild(second)
//   element.classList.add('move')

//   setTimeout(function () {
//     element.classList.remove('move')
//   }, 990)
//   setTimeout(function () {
//     element.removeChild(element.firstElementChild)
//   }, 990)
// }

// setInterval(updateTime, 100)
</script>