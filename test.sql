SELECT nfr.nid, nfr.moderation_state, nfr.title
FROM node_field_data as nfd
INNER JOIN node_field_revision as nfr on nfd.nid = nfr.nid and nfr.vid = (select max(vid) from node_field_revision where nid = nfr.nid)