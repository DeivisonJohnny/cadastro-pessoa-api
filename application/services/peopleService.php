<?php

namespace application\services;

use \SplitPHP\Service;

class PeopleService extends Service
{
   
  public function listAll()
  {
    $pessoas = $this->getDao('people')
      ->find('SELECT * FROM people ORDER BY nome');

    return $pessoas;
  }

  public function create($people) {
    $errors = $this->getService('utils/util')->validatePersonData($people);

    if (!empty($errors)) {
      return ['errors' => $errors];
    }

    $existingByCpf = $this->getDao('people')->filter('cpf')->equalsTo($people['cpf'])->find("SELECT cpf FROM people WHERE cpf = ?cpf?");
    if ($existingByCpf) {
      $errors[] = 'CPF já cadastrado.';
    }

    $existingByEmail = $this->getDao('people')->filter('email')->equalsTo($people['email'])->find("SELECT email FROM people WHERE email = ?email?");
    if ($existingByEmail) {
      $errors[] = 'Email já cadastrado.';
    }

    if (!empty($errors)) {
      return ['errors' => $errors];
    }

    return $this->getDao('people')->insert($people, false);
  }

  public function findOne($id) {
    $person = $this->getDao('people')
      ->filter('id')
      ->equalsTo($id)
      ->find('SELECT * FROM people WHERE id = ?id?');

    return $person ? $person[0] : null;
  }

  public function update($id, $people) {
    $existingPerson = $this->findOne($id);

    if (!$existingPerson) {
      return false;
    }

    $errors = $this->getService('utils/util')->validatePersonData($people);

    if (!empty($errors)) {
      return ['errors' => $errors];
    }

    $existingByCpf = $this->getDao('people')
      ->filter('cpf')
      ->equalsTo($people['cpf'])
      ->find("SELECT id, cpf FROM people WHERE cpf = ?cpf?");

    if ($existingByCpf && $existingByCpf[0]->id != $id) {
      $errors[] = 'CPF já cadastrado para outra pessoa.';
    }

    $existingByEmail = $this->getDao('people')
      ->filter('email')
      ->equalsTo($people['email'])
      ->find("SELECT id, email FROM people WHERE email = ?email?");

    if ($existingByEmail && $existingByEmail[0]->id != $id) {
      $errors[] = 'Email já cadastrado para outra pessoa.';
    }

    if (!empty($errors)) {
      return ['errors' => $errors];
    }

    
   $result = $this->getDao('people')
      ->filter('id')
      ->equalsTo($id)
      ->update($people);


      return $result;
  }

  /**
   * @param int|string $id
   * @return int
   */
  public function delete($id) {
    return $this->getDao('people')
      ->filter('id')
      ->equalsTo($id)
      ->delete();
  }

}