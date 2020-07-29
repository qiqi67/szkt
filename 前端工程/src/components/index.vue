<template >
    <el-carousel indicator-position="outside">
    <el-carousel-item v-for="item in imgList" :key="item.id">
      <el-row>
          <el-col :span="24"><img ref="imgHeight" :src="item.idView" class="banner_img"/></el-col>
        </el-row>
    </el-carousel-item>
  </el-carousel>
</template>
<script>
export default {
    data() {
    return{
        // 图片需要引入, 否则无法显示
        imgList: [
          {id: 0, idView: require('../assets/logo.png')},
          {id: 1, name: '详情', idView: require('../assets/1.jpg')},
          {id: 2, name: '推荐', idView: require('../assets/logo.png')}
        ]
    }
}
    
}
</script>
<style>
.el-carousel__item h1 {
    color: #475669;
    font-size: 18px;
    opacity: 0.75;
    line-height: fit-content;
    width: fit-content;
    margin: 0;
  }
  
  .el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
  }
  
  .el-carousel__item:nth-child(2n+1) {
    background-color: #d3dce6;
  }
</style>
