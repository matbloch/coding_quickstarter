# Model Definition











## Saving and loading models

**save**

- `torch.save`

```python
torch.save(model.state_dict(), PATH)
```

**load**

- `torch.load_state_dict`

```python
model = TheModelClass(*args, **kwargs)
model.load_state_dict(torch.load(PATH))
model.eval()
```

