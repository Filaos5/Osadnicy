<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
    <style>
        .content{
            font-size:40px;
        }
    </style>
</head>
<body>
    <div id="app" class="content" align="center">
        <h1>Hello From PHP File</h1>
        <h3>{{title}}</h3>
        <ul>
            <li v-for="(name,index) in names" :key="index">
                {{name}}
            </li>
        </ul>
        
    </div>
    <script src="https://unpkg.com/vue@next"></script>
    <script>

        const TestApp = {
            data(){
                return {
                    title: "Hello From Vuejs 3",
                    names: [
                        'Roger',
                        'Mark',
                        'John',
                        'Manu',
                        'Andrew'
                    ]
                }
            }
        }



        Vue.createApp(TestApp).mount("#app")
    </script>
</body>
</html>