<?php
  trait EnumsFunciones {

  public static function getRandom() {
    $enums = self::cases();
    return $enums[array_rand($enums)];
  } //END

  public static function allValues(): array {
     return array_column(self::cases(), 'value');
  } //END
  
  public static function allNames(): array {
    return array_column(self::cases(), 'name');
  } //END

  public static function forSelect(string $id, string $name, string $selected=''): String  {
    $opts = '';
    foreach (self::cases() as $case) {
      $is_selected = ($case->value==$selected) ? 'selected' : '';
      $opts .= "<option value=\"$case->value\" $is_selected>".$case->label()."</option>";
    }
    return "<select id=\"$id\" name=\"$name\" class=\"w3-input w3-border\">$opts</select>";
  } //END-forSelect

  public static function radio(string $legend='', string $name='', string $checked=''): String  {
    $opts = '';
    foreach (self::cases() as $case) {
      $is_checked = ($case->value==$checked) ? 'checked' : '';
      $opts .= "
        <input type=\"radio\" id=\"$case->value\" name=\"$name\" value=\"$case->value\" $is_checked />
        <label for=\"$case->value\">".$case->label()."</label>
      ";
    }
    return "
      <fieldset>
        <legend>$legend</legend>
        $opts
      </fieldset>";
  } //END-radio


  public function equals(self|int|string $other): bool {
    if (! $other instanceof self) {
      $other = self::from($other);
    }
    return $this === $other;
  }

  public function equalsAny(array $others): bool {
    foreach ($others as $other) {
      if ($this->equals($other)) {
        return true;
      }
    }
    return false;
  }

  public static function toArray($orden = true): array {
    return ($orden) 
    ? array_combine( 
        array_map(static fn (BackedEnum $enum) => $enum->name, self::cases()),
        array_map(static fn (BackedEnum $enum) => $enum->value, self::cases()),
      )
    : array_combine( 
      array_map(static fn (BackedEnum $enum) => $enum->value, self::cases()),
      array_map(static fn (BackedEnum $enum) => $enum->label(), self::cases()),
    );
    //return array_combine( self::allValues(), self::allNames() );
  }

} // END-TRAIT

/*
  enum Suit: string {
    case Clubs = '♣';
    case Diamonds = '♦';
    case Hearts = '♥';
    case Spades = '♠';
  }
  // ****************************
  $clubs = Suit::from('♥');
  var_dump($clubs); // enum(Suit::Hearts)
  echo $clubs->name; // "Hearts";
  echo $clubs->value; // "♥"
  // ****************************
  echo Suit::Clubs->name; // "Clubs"
  echo Suit::Clubs->value; // "♣"
  // ****************************
  Suit::cases();
  //->>  [Suit::Clubs, Suit::Diamonds, Suit::Hearts, Suit::Spaces]
  // ****************************
  $clubs = Suit::tryFrom('not-existing');
  var_dump($clubs); // null
  // ****************************
  serialize(Suit::Clubs); ->> 'Suit:Clubs'

 */
