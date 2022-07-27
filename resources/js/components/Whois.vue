<template>
    <div>
        <h1>Whois Domen</h1>
        <div v-if="err_message">
            <p>Error: The domen field is required.</p>
        </div>

        <form>
            <input type="text" v-model="domen" placeholder="domain name:"><br>
            <input type="text" v-model="domen1" placeholder="tesaract.uz"><br>
            <input type="text" v-model="domen2" placeholder="vk.ru"><br>
            <br>
            <button @click.prevent="store">Проверить</button>
        </form>
        <br><br/>
        <table>
            <tr>
                <th>Domain Created</th>
                <th>Domain Expires</th>
                <th>Domain Owner</th>
            </tr>
            <tr v-for="post in posts" v-if="post.domain_created">
                <td>{{ post.domain_created }}</td>
                <td>{{ post.domain_expires }}</td>
                <td>{{ post.domain_owner }}</td>
            </tr>
            <tr v-else>
                <td>{{ post }}</td>
            </tr>
        </table>
    </div>
</template>

<script>

import axios from 'axios';

export default {

    components: {},
    data: () => ({
            domen: "",
            domen1: "",
            domen2: "",
        posts: "",
        error: "",
        err_message: ""
    }),
    methods: {
        store: async function () {

            const arr = [this.domen, this.domen1, this.domen2]
            this.posts = []
            this.error = []
            console.log(this.err_message)

            for(let el of arr){
            try{
                let res = await axios.post('/api/whois', {"domen": el}, {
                    headers: {
                        "Content-type": "application/json"
                    }
                })
                    this.posts.push(res.data.post)

                this.error.push(false)
            } catch (e) {
                this.error.push(true)
            }
            }
            this.err_message = (this.error.indexOf(true) > -1)
        }
    }
}

</script>

<style scoped>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}

</style>
