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
        async downloadFile(name){
            const requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ name: name })
            };
            const response = await fetch("{!! url('/api/download_file') !!}", requestOptions);
            const data = await response.json();
            console.log(data);
        },
        inputSetUp(key, $event, share){
            const hiddenInput = document.getElementById(key);
            const selected = document.querySelector("#datalist_"+key+" option[value='"+$event.target.value+"']");
            hiddenInput.value = selected.dataset.value;
            if (share){
                const copycat = document.querySelectorAll('input[value-from=' + key + ']');
                const data = JSON.parse(selected.getAttribute('data-item'));
                for(var i = 0; i < copycat.length; i++) {
                    console.log(copycat[i], copycat[i].getAttribute("based"), selected);
                    copycat[i].value = data[copycat[i].getAttribute("based")];
                }
            }
        },
        inputSetIf(share, $event){
            const copycat = document.querySelectorAll('div[if]');
            for(var i = 0; i < copycat.length; i++) {
                var data = JSON.parse(copycat[i].getAttribute("if"));
                var hidden = false, found = false;
                for(var iif = 0; iif < data.length;iif+=3){
                    // console.log('before found', data[iif], share);
                    if (data[iif] == share){
                        // console.log('found!', copycat[i]);
                        hidden = ((data[iif+1] == $event.target.value) != data[iif+2]);
                        found = true;
                    }
                    if (hidden){
                        copycat[i].classList.add('hidden');
                        found = false;
                        break;
                    }
                }
                if (found){
                    for(var iif = 0; iif < data.length;iif+=3){
                        if (data[iif] != share){
                            const el = document.getElementById(data[iif]);
                            // console.log('found : check', copycat[i], el);
                            // console.log('next ', data[iif], data[iif+1], data[iif+2], el);
                            hidden = ((data[iif+1] == el.value) != data[iif+2]);
                            if (hidden){
                                copycat[i].classList.add('hidden');
                                break;
                            }
                        }
                    }
                    if (!hidden)
                        copycat[i].classList.remove('hidden');
                }
            }
        },
        inputDirect(share, $event){
            const copycat = document.querySelectorAll('div[if]');
            for(var i = 0; i < copycat.length; i++) {
                var data = JSON.parse(copycat[i].getAttribute("if"));
                for(var iif = 0; iif < data.length;iif+=3){
                    console.log('try to check', copycat[i], 'with_data=_',data[iif],'_and key = ',share)
                    if (data[iif] == share){
                        console.log('check if '+data[iif+2]+', '+data[iif+1]+" == "+$event.target.value)
                        if ((data[iif+1] == $event.target.value) == data[iif+2])
                            copycat[i].classList.remove('hidden');
                        else
                            copycat[i].classList.add('hidden');
                    }
                }
            }
        },
        uploadChange($event, key){
            console.log($event);
            const fileChosen = document.getElementById('file-chosen-'+key);
            fileChosen.textContent = $event.target.files[0].name;
        },
        onlyDate($event){
            console.log($event.target.value);
        },
        onCount($event, key){
            const output = document.getElementById(key);
            const xs = JSON.parse(output.getAttribute('from'))
            console.log($event.target.value,key, JSON.parse(output.getAttribute('from')));
            var value = 1;
            xs.forEach(x => {
                const element = document.getElementById(x);
                console.log('element = ', element);
                if (element.value == ''){
                    element.value = 0;
                    value = 0;
                }else if (element)
                    value*= parseInt(element.value);
            });
            output.value = value;
        }
    }
});
</script>
