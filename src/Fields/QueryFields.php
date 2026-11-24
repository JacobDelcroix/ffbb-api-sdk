<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Fields;

/**
 * Miroir de QueryFieldsManager : jeux de champs Directus par entité.
 */
final class QueryFields
{
    /** @return list<string> */
    public static function organismeSearch(): array
    {
        return FieldLists::ORGANISME_SEARCH;
    }

    /** @return list<string> */
    public static function organisme(FieldSet $fieldSet = FieldSet::Default): array
    {
        return match ($fieldSet) {
            FieldSet::Basic => FieldLists::ORGANISME_BASIC,
            FieldSet::Detailed => FieldLists::ORGANISME_DETAILED,
            default => FieldLists::ORGANISME_DEFAULT,
        };
    }

    /** @return list<string> */
    public static function competition(FieldSet $fieldSet = FieldSet::Default): array
    {
        return match ($fieldSet) {
            FieldSet::Basic => FieldLists::COMPETITION_BASIC,
            FieldSet::Detailed => FieldLists::COMPETITION_DETAILED,
            default => FieldLists::COMPETITION_DEFAULT,
        };
    }

    /** @return list<string> */
    public static function poule(FieldSet $fieldSet = FieldSet::Default): array
    {
        return match ($fieldSet) {
            FieldSet::Basic => FieldLists::POULE_BASIC,
            FieldSet::Detailed => FieldLists::POULE_DETAILED,
            default => FieldLists::POULE_DEFAULT,
        };
    }

    /** @return list<string> */
    public static function classement(): array
    {
        return FieldLists::POULE_CLASSEMENT;
    }

    /** @return list<string> */
    public static function equipes(): array
    {
        return FieldLists::ORGANISME_ENGAGEMENTS;
    }

    /** @return list<string> */
    public static function saison(FieldSet $fieldSet = FieldSet::Default): array
    {
        return $fieldSet === FieldSet::Detailed
            ? FieldLists::SAISON_DETAILED
            : FieldLists::SAISON_DEFAULT;
    }
}
