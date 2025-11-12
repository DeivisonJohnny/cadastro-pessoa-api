<?php

namespace application\routes;

use SplitPHP\Request;
use \SplitPHP\WebService;

class People extends WebService
{
  public function init()
  {
    $this->setAntiXsrfValidation(false);

    $this->addEndpoint('GET', '/', function ($params) {
      try {
        $people = $this->getService('peopleService')->listAll();
        return $this->response
          ->withStatus(200)
          ->withData([
            'success' => true,
            'data' => $people,
            'total' => count($people)
          ]);
      } catch (\Exception $e) {
        return $this->response
          ->withStatus(500)
          ->withData([
            'success' => false,
            'message' => 'Erro ao listar pessoas',
            'error' => $e->getMessage()
          ]);
      }
    });

    $this->addEndpoint('POST', '/', function (Request $req) {
      try {
        $dataBody  = (array) $req->getBody();
        $response =  $this->getService('peopleService')->create($dataBody);
        $response = is_object($response) ? (array) $response : $response;

        if (isset($response['errors'])) {
          return $this->response
            ->withStatus(400)
            ->withData([
              'success' => false,
              'message' => 'Existem erros de validação.',
              'errors' => $response['errors']
            ]);
        }

        return $this->response
          ->withStatus(201)
          ->withData([
            'success' => true,
            'message' => 'Pessoa cadastrada com sucesso.',
            'data' => $response
          ]);
      } catch (\Exception $e) {
        return $this->response
          ->withStatus(500)
          ->withData([
            'success' => false,
            'message' => 'Ocorreu um erro interno ao tentar cadastrar a pessoa.'
          ]);
      }
    });

    $this->addEndpoint('GET', '/?id?', function (Request $req) {
      try {
        $id = $req->getRoute()->params['id'];
        $person = $this->getService('peopleService')->findOne($id);

        if (!$person) {
          return $this->response
            ->withStatus(404)
            ->withData([
              'success' => false,
              'message' => 'Pessoa não encontrada.'
            ]);
        }

        return $this->response
          ->withStatus(200)
          ->withData([
            'success' => true,
            'data' => $person
          ]);
      } catch (\Exception $e) {
        return $this->response
          ->withStatus(500)
          ->withData([
            'success' => false,
            'message' => 'Erro ao buscar pessoa',
            'error' => $e->getMessage()
          ]);
      }
    });

    $this->addEndpoint('PUT', '/?id?', function (Request $req) {
      try {
        $id = $req->getRoute()->params['id'];
        $dataBody = $req->getBody();
        $response = $this->getService('peopleService')->update($id, $dataBody);
        $response = is_object($response) ? $response : $response;

        if (isset($response['errors'])) {
          return $this->response
            ->withStatus(400)
            ->withData([
              'success' => false,
              'message' => 'Existem erros de validação.',
              'errors' => $response['errors']
            ]);
        }

        if ($response === false) {
          return $this->response
            ->withStatus(404)
            ->withData([
              'success' => false,
              'message' => 'Pessoa não encontrada.'
            ]);
        }

        return $this->response
          ->withStatus(200)
          ->withData([
            'success' => true,
            'message' => 'Pessoa atualizada com sucesso.'
          ]);
      } catch (\Exception $e) {
        return $this->response
          ->withStatus(500)
          ->withData([
            'success' => false,
            'message' => 'Ocorreu um erro interno ao tentar atualizar a pessoa.',
            'error' => $e->getMessage()
          ]);
      }
    });

    $this->addEndpoint('DELETE', '/?id?', function (Request $req) {
      try {
        $id = $req->getRoute()->params['id'];

        $affectedRows = $this->getService('peopleService')->delete($id);

        if ($affectedRows < 1) {
          return $this->response
            ->withStatus(404)
            ->withData([
              'success' => false,
              'message' => 'Pessoa não encontrada.'
            ]);
        }

        return $this->response
          ->withStatus(200)
          ->withData([
            'success' => true,
            'message' => 'Pessoa removida com sucesso.'
          ]);
      } catch (\Exception $e) {
        return $this->response
          ->withStatus(500)
          ->withData([
            'success' => false,
            'message' => 'Erro ao remover pessoa',
            'error' => $e->getMessage()
          ]);
      }
    });
  }
}
