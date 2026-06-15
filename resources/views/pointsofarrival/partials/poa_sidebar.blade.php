<div class="poa-sidebar">
    <a href="./"><button class="non-accordion acc-btn">Home</button></a>
    <a href="./introduction"><button class="accordion acc-btn">Information</button></a>
    <a href="./films"><button class="accordion acc-btn">Points of Arrival Films</button></a>
    <a href="./themes"><button class="accordion acc-btn">Themes</button></a>
    <a href="./resources"><button class="accordion acc-btn">Resource List</button></a>
    <a href="./contact"><button class="accordion acc-btn">Contact</button></a>
    <a href="./accessibility"><button class="accordion acc-btn">Accessibility Statement</button></a>
</div>

<script>
var acc = document.getElementsByClassName("accordion");
for (var i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel && panel.style.display === "block") {
            panel.style.display = "none";
        } else if (panel) {
            panel.style.display = "block";
        }
    });
}
</script>
