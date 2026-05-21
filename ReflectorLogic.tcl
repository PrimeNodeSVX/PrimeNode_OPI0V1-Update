###############################################################################
#
# ReflectorLogic event handlers
#
###############################################################################

# The namespace is automatically set to the logic core name so there is no need
# to change it unless you have a good reason
namespace eval ${::logic_name} {

  # Zmieniona liczba argumentów - przyjmuje tylko jeden parametr {tg}
  proc tg_selected {tg} {
    
    # 1. Nasze nowe dwutonowe piknięcie (Niskie -> Wysokie)
    playTone 600 100 100
    playSilence 50
    playTone 1000 150 100
    playSilence 100

    # 2. Oryginalna zapowiedź głosowa SvxLinka (Gadaczka)
    if {$tg > 0} {
      playMsg "tg"
      playNumber $tg
    } else {
      # Jeśli wpiszesz 0#, czyli rozłączenie grupy
      playMsg "tg_0"
    }
  }

# end of namespace
}

#
# This file has not been truncated
#
