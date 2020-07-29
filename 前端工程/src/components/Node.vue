
<template>
  <div class="custom-tree-container">
   <el-button type="primary" @click="appendparentnode()">添加模块</el-button> <el-input placeholder="输入关键字进行过滤" ></el-input>
    <div class="block">

      <el-tree
        ref="tree"
        :data="data"
        :props="defaultProps"
        show-checkbox
        :node-key="id"
        :default-expanded-keys="key"
        :expand-on-click-node="false"
        
      >
        <span class="custom-tree-node" slot-scope="{ node, data }">
          <span>{{ node.label }}</span>
          <span>
            <el-button
              type="success"
              size="mini"
              icon="el-icon-circle-plus"
              circle
              v-if="node.level<=2"  
              @click=" () =>append(node,data) "
            ></el-button>
            <el-button
              type="primary"
              icon="el-icon-edit"
              circle
              size="mini"
              @click=" edit(node,data) "
            ></el-button>
            <el-button
              type="danger"
              icon="el-icon-delete"
              size="mini"
              
              @click="() => remove(node, data)"
              circle
            ></el-button>
          </span>
        </span>
      </el-tree>
      <el-dialog
        :title="title"
        :visible.sync="dialogVisible"
        width="30%"
        :close-on-click-modal="false"
      >
        <el-form :model="category">
          <el-form-item label="节点名称">
            <el-input autocomplete="off" v-model="category.name"></el-input>
          </el-form-item>
          <el-form-item label="节点描述">
            <el-input autocomplete="off" v-model="category.remark"></el-input>
          </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
          <el-button @click="dialogVisible = false">取 消</el-button>
          <el-button type="primary" @click="submitdata()">确 定</el-button>
        </span>
      </el-dialog>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      key: [],
      title: "",
      dialogType: "",
      dialogVisible: false,
      data: [],
      defaultProps: {
        children: "children",
        label: "name"
      },
      category: {
        id: null,
        pid: 0,
        name: "",
        remark: "",
        sort: 1,
        level: 0,
        status: 1
      }
    };
  },
  created() {
    this.getcategory();
  },
  methods: {
    appendparentnode() {
      this.dialogType = "parent";
      this.dialogVisible = true;
      this.title = "添加模块";

    },
    addparentnode() {
      console.log(this.category);
      this.$axios
        .post("/api/node/node/save", { data: this.category })
        .then(({ data }) => {
          this.$message({
            message: "模块节点保存成功",
            type: "success"
          });
        });
      this.dialogVisible = false;
      this.getcategory();
    },
    // filterNode(value,data) {
    //   if (!value) return true;
    //   return data.label.indexOf(value) !== -1;
    // },
    getcategory() {
      this.$axios
        .get("/api/node/node/ListToTree")
        .then(({ data }) => {
          this.data = data;
        })
        .catch(function(error) {
          // 请求失败处理
          console.log(error);
        });
    },
    append(node, data) {
      this.dialogType = "add";
      this.dialogVisible = true;
      this.title = "添加节点";
      console.log("获取节点中的内容", data);
      this.category.pid = data.id;
      this.category.level = data.level * 1 + 1;
    },
    edit(node, data) {
      this.dialogType = "edit";
      console.log(data);
      this.title = "修改节点";
      this.dialogVisible = true;
      this.category.name = data.name;
      this.category.remark = data.remark;
      this.category.id = data.id;
      this.category.level = data.level;
      this.category.pid = data.pid;
      console.log(this.category);
    },
    addcategory() {
      console.log(this.category);
      this.$axios
        .post("/api/node/node/save", { data: this.category })
        .then(({ data }) => {
          this.$message({
            message: "节点保存成功",
            type: "success"
          });
        });
      this.dialogVisible = false;
      this.getcategory();
    },
    submitdata() {
      if (this.dialogType == "add") {
        this.addcategory();
      }
      if (this.dialogType == "edit") {
        this.editcategory();
      }
      if (this.dialogType == "parent") {
        this.addparentnode();
      }
    },
    editcategory() {
      console.log(this.category);
      this.$axios
        .post("/api/node/node/update", { data: this.category })
        .then(({ data }) => {
          this.$message({
            message: "节点修改成功",
            type: "success"
          });
        });
      this.dialogVisible = false;
      this.getcategory();
    },
    remove(node, data) {
      console.log("获取当前节点数据", data);
      this.$confirm(`是否删除【${data.name}】节点?`, "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.$axios
            .get(`/api/node/node/delete?id=${data.id}`)
            .then(
              this.$message({
                type: "success",
                message: "删除成功!"
              }),
              this.getcategory(),
              (this.key = [node.parent.data.id])
            )
            .catch(function(error) {
              // 请求失败处理
              console.log(error);
            });
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "已取消删除"
          });
        });
    }
  },
  // watch: {
  //   filterText(val) {
  //     this.$refs.tree.filter(val);
  //   }
  // }
};
</script>

<style>
.custom-tree-node {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 14px;
  padding-right: 8px;
}
</style>
