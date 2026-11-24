<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Support;

use CoachBasket\Ffbb\Models\ContactInfo;

/**
 * Extraction défensive des contacts (miroir de club_contacts.py et engagement_contacts.py).
 */
final class ContactExtractor
{
    /**
     * @param  array<string, mixed>  $organisme
     */
    public static function clubInfo(array $organisme): ?ContactInfo
    {
        $phone = self::phone($organisme['telephone'] ?? null);
        $email = self::str($organisme['mail'] ?? null);

        if ($phone === null && $email === null) {
            return null;
        }

        return new ContactInfo(nom: self::str($organisme['nom'] ?? null), telephone: $phone, email: $email, role: 'club');
    }

    /**
     * @param  array<string, mixed>  $organisme
     * @return list<ContactInfo>
     */
    public static function membres(array $organisme): array
    {
        $contacts = [];
        $membres = is_array($organisme['membres'] ?? null) ? $organisme['membres'] : [];

        foreach ($membres as $membre) {
            if (! is_array($membre)) {
                continue;
            }

            $phone = self::phone(self::first($membre, ['telephonePortable', 'telephone_portable', 'telephoneFixe', 'telephone_fixe']));
            $email = self::str($membre['mail'] ?? null);

            if ($phone === null && $email === null) {
                continue;
            }

            $contacts[] = new ContactInfo(
                nom: self::name($membre['nom'] ?? null),
                prenom: self::name($membre['prenom'] ?? null),
                email: $email,
                telephone: $phone,
                role: self::first($membre, ['codeFonction', 'code_fonction']) ?? 'membre',
            );
        }

        return $contacts;
    }

    /**
     * @param  array<string, mixed>  $engagement
     */
    public static function correspondant(array $engagement): ?ContactInfo
    {
        $phone = self::phone(self::first($engagement, [
            'telephonePortableCorrespondantEquipe',
            'telephone_portable_correspondant_equipe',
            'telephoneFixeCorrespondantEquipe',
            'telephone_fixe_correspondant_equipe',
            'telephone',
        ]));
        $email = self::first($engagement, ['emailCorrespondantEquipe', 'email_correspondant_equipe', 'email']);

        if ($phone === null && $email === null) {
            return null;
        }

        return new ContactInfo(
            nom: self::name(self::first($engagement, ['nomCorrespondantEquipe', 'nom'])),
            prenom: self::name(self::first($engagement, ['prenomCorrespondantEquipe', 'prenom'])),
            email: $email,
            telephone: $phone,
            role: 'correspondant',
        );
    }

    /**
     * @param  array<string, mixed>|null  $entraineur
     */
    public static function entraineur(?array $entraineur, ?string $titre): ?ContactInfo
    {
        if ($entraineur === null || $entraineur === []) {
            return null;
        }

        $phone = self::phone(self::first($entraineur, [
            'telephonePortable', 'telephone_portable', 'telephoneDomicile', 'telephone_travail', 'telephone',
        ]));
        $email = self::str($entraineur['email'] ?? null);
        $nom = self::str($entraineur['nom'] ?? null);
        $prenom = self::str($entraineur['prenom'] ?? null);

        if ($phone === null && $email === null && $nom === null && $prenom === null) {
            return null;
        }

        return new ContactInfo(nom: self::name($nom), prenom: self::name($prenom), email: $email, telephone: $phone, role: $titre);
    }

    /**
     * Identifiant d'entraîneur (ou d'adjoint) d'un engagement, quelle que soit la forme du champ.
     *
     * @param  array<string, mixed>  $engagement
     * @param  list<string>  $keys
     */
    public static function relatedId(array $engagement, array $keys): ?string
    {
        foreach ($keys as $key) {
            $value = $engagement[$key] ?? null;

            if (is_array($value)) {
                $value = $value['id'] ?? $value['idLicence'] ?? null;
            }

            if ((is_string($value) || is_int($value)) && (string) $value !== '') {
                return (string) $value;
            }
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  list<string>  $keys
     */
    private static function first(array $data, array $keys): ?string
    {
        foreach ($keys as $key) {
            $value = self::str($data[$key] ?? null);

            if ($value !== null) {
                return $value;
            }
        }

        return null;
    }

    private static function str(mixed $value): ?string
    {
        if (! is_string($value) && ! is_int($value)) {
            return null;
        }

        $value = (string) $value;

        return $value === '' ? null : $value;
    }

    private static function phone(mixed $raw): ?string
    {
        $value = self::str($raw);

        return $value === null ? null : trim($value);
    }

    /**
     * Équivalent de str.strip().title() en Python.
     */
    private static function name(mixed $name): ?string
    {
        $value = self::str($name);

        return $value === null ? null : mb_convert_case(trim($value), MB_CASE_TITLE, 'UTF-8');
    }
}
