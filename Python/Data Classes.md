# Data Classes





- Auto-generated constructor
- Alternative to Tuple or Dict
- `@dataclass` decorator



**Definition**

```python
from dataclasses import dataclass

@dataclass
class PlayingCard:
    rank: str
    suit: str
    cost: float = 0.0. # default value
      
@dataclass
class Deck:
    cards: List[PlayingCard]
```

**Usage**

```python
card = PlayingCard('Q', 'Hearts')
card.rank
```

**Advanced default values**

```python
from dataclasses import dataclass, field
from typing import List

RANKS = '2 3 4 5 6 7 8 9 10 J Q K A'.split()
SUITS = '♣ ♢ ♡ ♠'.split()

def make_french_deck():
    return [PlayingCard(r, s) for s in SUITS for r in RANKS]

@dataclass
class Deck:
    cards: List[PlayingCard] = field(default_factory=make_french_deck)
```

**Immutable Data Classes**

```python
from dataclasses import dataclass

@dataclass(frozen=True)
class Position:
    name: str
    lon: float = 0.0
    lat: float = 0.0
```



