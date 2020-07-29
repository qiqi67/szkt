<?php
namespace app\node\controller;
use think\Controller;
use app\node\model\Node as nodeModel;
class Node extends Controller{
	  
	  // $node=new nodeModel();
	  
	  public function get(){
		  // $user = User::get(['name' => 'thinkphp']);
		  $list=nodeModel::all(['status'=>1]);
		  $list =  json_decode( json_encode( $list),true);
		  // dump($object);
		  return $list;
		  
	  }
	  
	  function ListToTree( $rootId = 0, $pkName = 'id', $pIdName = 'pid', $childName = 'children')
	      {
			  $dataArr=$this->get();
	          $tree = [];
	          if (is_array($dataArr))
	          {
	              //1.0 创建基于主键的数组引用
	              $referList  = [];
	              foreach ($dataArr as $key => & $sorData)
	              {
	                  $referList[$sorData[$pkName]] =& $dataArr[$key];
	              }
	  
	              //2.0 list 转换为 tree
	              foreach ($dataArr as $key => $data)
	              {
	                  $pId = $data[$pIdName];
	                  if ($rootId == $pId) //一级
	                  {
	                      $tree[] =& $dataArr[$key];
	                  }
	                  else //多级
	                  {
	                      if (isset($referList[$pId]))
	                      {
	                          $pNode               =& $referList[$pId];
	                          $pNode[$childName][] =& $dataArr[$key];
	                      }
	                  }
	              }
	          }
	  
	          return $tree;

			  }
			  
		public function save(){
			$data=input('post.');
			// $data=json_decode($data, true)
			// dump($data['data']);
			// die;
			// $data=$data['data']
			$request = request();
			$user = new nodeModel($data['data']);
			// // 过滤post数组中的非数据表字段数据
			 $user->allowField(true)->save();
				return  200;
		}
		public function update(){
			$data=input('post.');
			$user = new nodeModel();
			$list=[$data['data']];
			$user->saveAll($list);
			return 200;
		}
		public function delete(){
			$id=input('get.id');
			$node=nodeModel::get($id);
			$node->status=0;
			$node->save();
			return 200;
		}
		
			 
					  

}
