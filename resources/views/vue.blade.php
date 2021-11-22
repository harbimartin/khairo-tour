@yield('index')
<script>
var vue = new Vue({
    el:"#vue-app",
    data : {
        header: "E-Budget",
        content : 0,
        test : false,
        onReject : false,
        onImport : false,
        title : 'aeeaea',
        form : {},
    },
    methods:{
        inputSetUp(key, $event){
            const hiddenInput = document.getElementById(key);
            const selected = document.querySelector("#datalist_"+key+" option[value='"+$event.target.value+"']");
            const copycat = document.querySelectorAll('input[value-from=' + key + ']');
            const data = JSON.parse(selected.getAttribute('data-item'));
            hiddenInput.value = selected.dataset.value;
            for(var i = 0; i < copycat.length; i++) {
                console.log(copycat[i], copycat[i].getAttribute("based"), selected);
                copycat[i].value = data[copycat[i].getAttribute("based")];
            }
        },
        inputSetIf(key, $event){
            const hiddenInput = document.getElementById(key);
            const copycat = document.querySelectorAll('div[if]');
            for(var i = 0; i < copycat.length; i++) {
                var data = JSON.parse(copycat[i].getAttribute("if"));
                for(var iif = 0; iif < data.length;iif+=3){
                    if (data[iif] == key && (data[iif+1] == $event.target.value) == data[iif+2])
                        copycat[i].classList.remove('hidden');
                    else
                        copycat[i].classList.add('hidden');
                }
            }
        }
    }
});
// vue.$watch('getInputValue', function (key) {
//     this.form[key] = $event.target.value;
// })
</script>
