<?php

namespace app\system\controller;

use think\Controller;
use think\Db;
use think\facade\Config;

class Component extends Controller
{

    //上传文件
    public function uploader ()
    {
        $url_base =  Config::get('app.HD_ROOT');
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move( './uploads');
        if($info){
            $data = [
                'name'       => input( 'post.name' ) ,
                'filename'   => $info->getFilename() ,
                'path'       => 'uploads/' . str_replace('\\','/',$info->getSaveName()) ,
                'extension'  => $info->getExtension() ,
                'createtime' => time() ,
                'size'       => $info->getSize() ,
            ];
            Db::name( 'attachment' )->insert( $data );
            echo json_encode( [ 'valid' => 1 , 'message' =>   $url_base.'uploads/' . str_replace('\\','/',$info->getSaveName()) ] );
        }else{
            // 上传失败获取错误信息
            echo json_encode( [ 'valid' => 0 , 'message' => $file->getError() ] );
        }
       die();

    }

    //获取文件列表
    public function filesLists ()
    {

        $db   = Db::name( 'attachment' )->whereIn( 'extension' , explode( ',' , strtolower( input( "post.extensions" ) ) ) )->order( 'id desc' );
        $Res  = $db->paginate( 2 );
        $data = [];
        if ( $Res->toArray() ) {
            //dump($Res->toArray());die;
            foreach ( $Res as $k => $v ) {
                $data[ $k ][ 'createtime' ] = date( 'Y/m/d' , $v[ 'createtime' ] );
                $data[ $k ][ 'size' ]       = $v[ 'size' ];
                $data[ $k ][ 'url' ]        =  Config::get('app.HD_ROOT') . $v[ 'path' ];
                $data[ $k ][ 'path' ]       =  Config::get('app.HD_ROOT') . $v[ 'path' ];
                $data[ $k ][ 'name' ]       = $v[ 'name' ];
            }
        }
        echo json_encode( [ 'data' => $data , 'page' => $Res->render() ? : '' ] );
    }
}
