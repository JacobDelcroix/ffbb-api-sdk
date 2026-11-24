<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Support\ContactExtractor;

it('extrait les membres avec téléphone ou e-mail, noms en casse titre', function () {
    $membres = ContactExtractor::membres(['membres' => [
        ['nom' => 'DUPONT', 'prenom' => 'jean', 'telephonePortable' => ' 0601020304 ', 'codeFonction' => 'PRES'],
        ['nom' => 'SANS CONTACT'],
    ]]);

    expect($membres)->toHaveCount(1)
        ->and($membres[0]->nom)->toBe('Dupont')
        ->and($membres[0]->prenom)->toBe('Jean')
        ->and($membres[0]->telephone)->toBe('0601020304')
        ->and($membres[0]->role)->toBe('PRES');
});

it('renvoie un entraîneur même sans coordonnées si un nom est connu', function () {
    expect(ContactExtractor::entraineur(['nom' => 'MARTIN'], 'entraineur')?->nom)->toBe('Martin')
        ->and(ContactExtractor::entraineur([], 'entraineur'))->toBeNull();
});

it('lit un identifiant lié sous forme scalaire ou objet', function () {
    expect(ContactExtractor::relatedId(['idEntraineur' => ['id' => 42]], ['idEntraineur']))->toBe('42')
        ->and(ContactExtractor::relatedId(['entraineur' => 7], ['idEntraineur', 'entraineur']))->toBe('7');
});
