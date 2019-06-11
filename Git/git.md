# Git

**Searching in files for string**
`git grep -i somestring`

**Setting up SSH Keys**


**Update Master from Branch `bugfix`**
```cpp
git checkout master
git pull
git merge --squash bugfix
git commit
```

#### Squashing Commits

**Write new commit message**

`git reset --soft HEAD~3 &&` squash last 3 commits



#### Cherry Picking

**From another branch**

`git cherry-pick -x ea6128347797b9c268d95257ef17cb6ac0baaaab`

**Pick merge request**

`git checkout my-target-branch`

`git cherry-pick -m 1 ea6128347797b9c268d95257ef17cb6ac0baaaab`





#### Update Branch `bugfix` from Master

see: [Docs](https://git-scm.com/book/en/v2/Git-Branching-Rebasing)
- Merge: Leaves history intact
    - `git checkout bugfix`
    - `git merge origin/master`
- Rebase: Create commit to get on current state of master
	- `git fetch`
	- `git rebase origin/master`
- Update:
	- `git push --force` (remote history is overwritten)

**Example**
Initial history:
```bash
A --- B --- C --- D <-- master
 \
  \-- E --- F --- G <-- b1
```

History after merging master into branch `b1`:
```bash
A --- B --- C --- D <-- master
 \                 \
  \-- E --- F --- G +-- H <-- b1
```

History after rebase:
```bash
A --- B --- C --- D <-- master
                   \
                    \-- E' --- F' --- G' <-- b1
```


