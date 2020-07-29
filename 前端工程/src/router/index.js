import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import MyTable from '@/components/MyTable'
import Node from '@/components/Node'
import index from '@/components/index'
Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'index',
      component: index
    },
    {
      path:'/mytable',
      name:'MyTable',
      component:MyTable
    },
    {
      path:'/node',
      name:'node',
      component:Node

    }

  ]
})
