<?php
    class LearningResult extends Controllers{

        public function __construct(){
            parent::__construct();
        }

        public function LearningResult(string $page){
            $page = intval(strClean($page));
            $data['page_tag'] = 'Resultados de aprendizaje';
            $data['page_title'] = 'Resultados de aprendizaje';
            $data['pagination'] = ceil($this->getLearningResultAmount()/12);
            $data['page_functions_js'] = "functions_learning_result.js";
            $this->views->getView($this,"LearningResult",$data);
        }

        public function SearchBar($page){
            $words = "";
            if(isset($_POST['query'])){
                $words = strClean($_POST['query']);
            }
            $arrData = "";
            if (empty($words)){
                $arrData = $this->getLearningResult();
            } else {
                $arrData = $this->model->searchBarQuery($words);
		$this->printHtmlCode($arrData);
            }
        }

        public function getLearningResultAmount(){
            $data = $this->model->searchLearningResultAmount();
            return $data[0]['amount'];
        }

        public function getLearningResult(){
            $offset = 0;
            if(isset($_POST['pageNumber'])){
                $offset = intval(strClean($_POST['pageNumber']));
            }
            $offset = $offset * 12;
            $arrData = $this->model->searchAllLearningResult($offset);
            $this->printHtmlCode($arrData);
        }

        public function getLearningResultSelect(){
            $htmlOptions = "";
            $arrData = $this->model->searchAllLearningResultSelect();
            if(count($arrData) > 0){
                for($i = 0; $i <count($arrData); $i++){
                    $htmlOptions .= '<option value="'.$arrData[$i]['codigo'].'">'.$arrData[$i]['descripcion'].'</option>';
                }
            }
            echo $htmlOptions;
            die();
        }

        public function getLearningResultById(int $id){
            $id = intval(strClean($id));
            if($id > 0){
                $arrData = $this->model->searchLearningResultById($id);
		$arrData['detalle'] = nl2br($arrData['detalle']);
                $this->getByIdLRMessage($arrData);
            }
            die();
        }

        private function getLastCode(){
            $data = $this->model->searchLastCode();
            return $data[0]['code'];
        }

        private function getByIdLRMessage($arrData){
            $arrResponse = "";
            if (empty($arrData)){
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
            } else {
                $arrResponse = array('status' => true, 'msg' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            return $arrResponse;
        }

        private function printHtmlCode($arrData){
            $response = "";
            if(count($arrData) > 0){
                foreach($arrData as $key=>$value):
                    $response.='<div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">'.$value['descripcion'].'</h5>
                                            <div class="card-initial-page">
                                            <div>'
                                                .$value['detalle'].'
                                            </div>
                                            <button type="button" class="btn btn-link" onclick="viewMore(this)" lr="'.$value['codigo'].'"></button>
                                        </div>
                                    <div class="text-center" id="view-subjects">
                                    <a href="'. baseUrl().'Subject/Subject/'.$value['codigo'].'" class="btn bd-yellow-300">Espacios académicos</a>
                                </div>
                        </div>
                    </div>
                </div>';
                endforeach;
            } else {
                $response.='No se encontrados resulados que coincidan con su b&uacutesqueda';
            }
            echo $response;
        }
    }
?>