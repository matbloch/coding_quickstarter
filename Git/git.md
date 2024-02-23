# Git



**File Permissions**

- also submitted



## Common Operations

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





#### Rebase last X commits onto different branch

```bash
git rebase -i HEAD~10 --onto another_branch
```







## Cheatsheet



| Task                                                         | Operation                          |
| ------------------------------------------------------------ | ---------------------------------- |
| Undo a conflicting  `stash pop` . Stash can be applied again. | `git reset --merge`                |
| Reset last `5` commits into staged                           | `git reset --soft HEAD~5`          |
| Cherrypick a specific commit                                 | `git cherry-pick -m 1 <commit-id>` |











## Submodules



**Adding Submodules**



**Initialization**

`git submodule update --init --recursive`



**Update**

- Automatically: `git submodule update --remote --merge`

- Manually:
  1. `cd` to sub-repository
  2. `git pull origin master`
  3. `cd ..` and commit



**Remove a submodule**

- git rm <path>
- remove entry from .gitmodules
- (remove git data in .git/modules/<path>)





## Git LFS



1. `git lfs install` Install git LFS for current user account
2. `git lfs track "*.psd"` Start to track file
   - Will add filter to `.gitattributes`
3. `git add .gitattributes` track the filter with git
   - ``git lfs install` Install git LFS for current user account
4. `git add file.psd` track files the regular way





