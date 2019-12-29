# Networking



## VPC and Subnet Basics

- **VPC:** Virtual Private Coud, dedicated to your AWS account
  - On creation: Specify range of IPv4 addresses using a "Classless Inter-Domain Routing" (CIDR) block, e.g. `10.0.0.0/16`
  - Spans all availability zones in the region



- **Subnets:** Allow service separation and higher security
  - On creation: Specify IP range using a CIDR block that is a subset of the VPC CIDR block.
  - Subnets cannot span multiple availability zones



- launch instances in separate availability zone to protect from failure of a single location





- public/private subnets: Subnet is public if traffic is routed to an internet gateway





**Subnet Setup Best practice**

- Bis zu vier Availability Zones für hohe Verfügbarkeit und Notfallwiederherstellung Availability Zones sind geografisch  innerhalb einer Region verteilt, zur besten Isolierung und Stabilität  während einer Naturkatastrophe. Wir empfehlen, dass Sie Ihre Verwendung  von Availability Zones maximieren, um sich gegen Datenzentrumsausfall zu schützen.
- Separate Subnetze für unterschiedliche  Routing-Anforderungen. Wir empfehlen, dass Sie öffentliche Subnetze für  externe Ressourcen und private Subnetze für externe Ressourcen  verwenden. Für jede Availability Zone stellt dieser Quick Start  standardmäßig ein öffentliches sowie ein privates Subnetz bereit.
- Zusätzliche Ebene an Sicherheit. Wir empfehlen, dass  Sie Zugriffskontrolllisten (ACLs) als Firewalls verwenden, um  eingehenden und ausgehenden Traffic auf der Subnetz-Ebene zu  kontrollieren. Dieser Quick Start bietet eine Option, um ein vom  Netzwerk-ACL Geschützes Subnetz in jeder Availability Zone zu erstellen. Diese Netzwerk-ACLs bieten individuelle Steuerungsmöglichkeiten, die  Sie als eine zweite Verteidigungslinie anpassen können.
- Unabhängige Routing-Tabellen, die für jedes private  Subnetz konfiguriert sind, um den Traffic in und aus der VPC zu  kontrollieren. Das öffentliche Subnetz teilt eine einzelne  Routing-Tabelle, da sie alle denselben Internet-Gateway als einzige  Route verwenden, um mit dem Internet zu kommunizieren.
- Hochverfügbare NAT-Gateways anstelle von  NAT-Instances. NAT-Gateways bieten große Vorteile, wenn es um die  Bereitstellung, Verfügbarkeit und Wartung geht.
- Sparen Sie sich Kapazitäten für zusätzliche Subnetze, um Ihre Umgebung zu unterstützen, während Sie wächst oder sich mit der  Zeit verändert.





## Elastic Load Balancing (ELB)

The Load Balancer should be your gateway to the cluster. When running a  web service, make sure you've running your cluster in a private subnet  and your containers cannot be accessed directly from the internet.  Ideally, your internal container should expose a random, ephemeral port  which is bound to a target group. Make sure also that traffic is only  allowed from the Load Balancer's Security Group.





## Network Address Translation (NAT) Gateways

- Network Address Translation (NAT)

