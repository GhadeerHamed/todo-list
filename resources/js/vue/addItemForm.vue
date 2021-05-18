<template>
    <div class="addItem">
        <input type="text" v-model="item.name">
        <font-awesome-icon
            icon="plus-square"
            @click="this.reloading === false ? addItem() : '' "
            :class="[item.name ? 'active' : 'inactive',  'plus']"
        />
    </div>
</template>

<script>
export default {
    name: "addItemForm",
    data: function () {
        return {
            item: {
                name: ""
            },
            reloading: false
        }
    },
    methods: {
        addItem: function () {
            this.reloading = true;
            if (this.item.name === '') {
                this.reloading = false;
                return;
            }

            axios.post('api/items', {
                item: this.item
            }).then(response => {
                if (response.status === 201) {
                    this.item.name = '';
                    this.reloading = false;
                    this.$emit('reloadList')
                }
            }).catch(error => {
                console.log(error)
                this.reloading = false;
            })
        }
    }
}
</script>

<style scoped>
.addItem {
    display: flex;
    justify-content: center;
    align-items: center;
}

input {
    background: #f7f7f7;
    border: 0px;
    outline: none;
    padding: 5px;
    margin-right: 10px;
    width: 100%;
}

.plus {
    font-size: 20px;
}

.active {
    color: #00ce25;
}

.inactive {
    color: #999999;
}
</style>
