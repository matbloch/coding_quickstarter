# Boot Management

- Boot order: [Bios] > [Boot Order Selection] > [Primary HDD] > Master Boot Record > Boot loader > Specified OS

**Master Boot Record (MBR)**
- First sector on Harddrive, 512 bytes
- 446 bytes boot loader
- 64 bytes partition table (list of primary/extended partitions)

**Linux/Windows Bootloaders**
- Linux can only be started by GRUB
- Windows can only be started by Windows bootloader

----------------

### Fixing your MBR

#### Case 1: Repair Windows MBR
- Boot from Windows Boot Stick
- Click "Repair Computer"
- Select "Troubleshooting" > "Advanced Options" > "Command Prompt"

#### Case 2: Erase/Reset MBR

**delete all partitions**
- `diskpart`
- `list disk` list disks
- `sel disk 0` (select hd by number)
- `list part` list partitions
- `sel part 1` select partition 1
- `del part override` delete this partition

--------------------
### Dual Boot: Win + Linux
- Bootloader: Grub. Load Linux or Windows bootloader
- Scenario: Windows and Ubuntu on separate drives

#### Windows Installation (Disk0)
- First install Windows as usual

#### Ubuntu installation (Disk1)

- Install Linux: Select "Other installation type"

**Partitioning**
1. Create new partition with ~RAM size, select "use as swap" (for memory swapping)
2. Create new partition for filesystem (kernel, boot files, system files, libraries etc), mount at `/`, use `Ext4` formating
3. Create new partition for `/home` using `Ext4` formating
4. select drive and click "install now"


- Select your drive to install the bootloader GRUB on
- Select your drive to install linux on (format as EXFAT4)


### The Windows Bootloader

**Display active boot options**

- A. `msconfig` > "Start"
- B. Open new terminal as admin and enter: `bcdedit`

```bash
C:\WINDOWS\system32>bcdedit

Windows-Start-Manager
---------------------
Bezeichner              {bootmgr}
device                  partition=C:
description             Windows Boot Manager
locale                  de-DE
inherit                 {globalsettings}
default                 {current}
resumeobject            {eb8b99ed-ddd7-11e7-947a-90c110837293}
displayorder            {current}
                        {40410e52-f5c6-11e4-b335-b9c94abbc75d}
toolsdisplayorder       {memdiag}
timeout                 5

Windows-Startladeprogramm
-------------------------
Bezeichner              {current}
device                  partition=C:
path                    \WINDOWS\system32\winload.exe
description             Windows 10
locale                  de-DE
inherit                 {bootloadersettings}
recoverysequence        {1a50fb7b-ddd8-11e7-947a-90c110837293}
displaymessageoverride  Recovery
recoveryenabled         Yes
allowedinmemorysettings 0x15000075
osdevice                partition=C:
systemroot              \WINDOWS
resumeobject            {eb8b99ed-ddd7-11e7-947a-90c110837293}
nx                      OptIn
bootmenupolicy          Standard
hypervisorlaunchtype    Auto

Windows-Startladeprogramm
-------------------------
Bezeichner              {40410e52-f5c6-11e4-b335-b9c94abbc75d}
device                  partition=F:
path                    \Windows\system32\winload.exe
description             Windows 7
locale                  de-DE
inherit                 {bootloadersettings}
recoverysequence        {40410e55-f5c6-11e4-b335-b9c94abbc75d}
recoveryenabled         Yes
osdevice                partition=F:
systemroot              \Windows
resumeobject            {40410e51-f5c6-11e4-b335-b9c94abbc75d}
nx                      OptIn
```

